<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageGenerationService
{
    protected $apiKey;
    protected $baseUrl;
    protected $claudeService;
    
    public function __construct(ContentGenerationService $claudeService)
    {
        // Using Claude AI for prompt enhancement
        $this->claudeService = $claudeService;
        
        // Set OpenAI as backup (check if available)
        $this->apiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));
        $this->baseUrl = 'https://api.openai.com/v1';
    }

    /**
     * Generate image using Claude AI enhanced prompts
     */
    public function generateImage(string $prompt, array $options = []): array
    {
        try {
            Log::info('Image Generation Started', [
                'prompt' => $prompt,
                'options' => $options
            ]);
            
            $style = $options['style'] ?? 'realistic';
            $size = $options['size'] ?? '1024x1024';
            $quality = $options['quality'] ?? 'standard';
            
            // Check if Claude service is available
            if (!$this->claudeService) {
                Log::error('Claude service not available for prompt enhancement');
                return [
                    'success' => false,
                    'error' => 'خدمة Claude غير متاحة لتحسين الوصف'
                ];
            }
            
            // Use Claude AI to enhance the prompt
            $enhancedPrompt = $this->enhancePromptWithClaude($prompt, $style);
            
            Log::info('Claude-Enhanced AI Image Generation Request', [
                'original_prompt' => $prompt,
                'enhanced_prompt' => $enhancedPrompt,
                'style' => $style,
                'size' => $size,
                'quality' => $quality
            ]);

            // Try multiple image generation services
            $imageResult = $this->generateWithMultipleServices($enhancedPrompt, $size, $quality);
            
            if ($imageResult['success']) {
                // Check if the image_url is already a local path or needs to be downloaded
                $imageUrl = $imageResult['image_url'];
                
                // Check if it's an external URL that needs downloading
                $isExternalUrl = filter_var($imageUrl, FILTER_VALIDATE_URL) && 
                                !str_contains($imageUrl, config('app.url')) &&
                                !str_contains($imageUrl, '/public/storage/') &&
                                !str_contains($imageUrl, '/storage/');
                
                if ($isExternalUrl) {
                    // It's an external URL, download and save locally
                    $localImagePath = $this->saveImageLocally($imageUrl, $prompt);
                } else {
                    // It's already a local path (from Stability AI base64 save)
                    $localImagePath = $imageUrl;
                }
                
                return [
                    'success' => true,
                    'image_url' => $localImagePath,
                    'original_url' => $imageResult['image_url'],
                    'prompt' => $enhancedPrompt,
                    'original_prompt' => $prompt,
                    'style' => $style,
                    'size' => $size,
                    'service_used' => $imageResult['service'],
                    'usage' => $imageResult['usage'] ?? []
                ];
            }

            return $imageResult;

        } catch (\Exception $e) {
            Log::error('Claude-Enhanced Image Generation Exception: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => 'حدث خطأ أثناء توليد الصورة: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Enhance prompt using Claude AI
     */
    protected function enhancePromptWithClaude(string $prompt, string $style): string
    {
        try {
            Log::info('Starting Claude prompt enhancement', [
                'original_prompt' => $prompt,
                'style' => $style
            ]);
            
            $styleInstructions = [
                'realistic' => 'photorealistic, high quality, detailed, professional photography',
                'digital-art' => 'digital art style, modern, clean design, vector illustration',
                'illustration' => 'illustration style, artistic, creative, hand-drawn artwork',
                'cartoon' => 'cartoon style, colorful, friendly, animated character design',
                'photography' => 'professional photography, well lit, high resolution, commercial photo',
                'abstract' => 'abstract art, creative, unique design, artistic interpretation'
            ];
            
            $styleInstruction = $styleInstructions[$style] ?? 'high quality, professional';
            
            $enhancementPrompt = "You are an expert image prompt engineer. Take the following basic image description and enhance it into a detailed, professional image generation prompt.

Basic description: {$prompt}
Desired style: {$style}

Create a detailed prompt that includes:
- Visual composition and layout
- Color palette and lighting
- Technical specifications for {$styleInstruction}
- Professional quality indicators
- Service/business context elements

Return only the enhanced prompt, no explanations. Make it concise but detailed (maximum 150 words).";
            
            Log::info('Calling Claude for prompt enhancement');
            
            $response = $this->claudeService->generateContent($enhancementPrompt, 'image_description', 'en');
            
            Log::info('Claude response received', [
                'response' => $response
            ]);
            
            if ($response['success'] && !empty($response['content'])) {
                $enhancedPrompt = trim($response['content']);
                Log::info('Claude enhanced prompt successfully', [
                    'original' => $prompt,
                    'enhanced' => $enhancedPrompt
                ]);
                return $enhancedPrompt;
            } else {
                Log::warning('Claude enhancement failed', [
                    'response' => $response
                ]);
            }
            
            // Fallback to basic enhancement if Claude fails
            Log::info('Using fallback prompt enhancement');
            return $this->enhancePrompt($prompt, $style);
            
        } catch (\Exception $e) {
            Log::error('Claude prompt enhancement exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->enhancePrompt($prompt, $style);
        }
    }
    
    /**
     * Enhance prompt based on style (fallback method)
     */
    protected function enhancePrompt(string $prompt, string $style): string
    {
        $styleInstructions = [
            'realistic' => 'photorealistic, high quality, detailed, professional',
            'digital-art' => 'digital art style, modern, clean design, vector style',
            'illustration' => 'illustration style, artistic, creative, hand-drawn style',
            'cartoon' => 'cartoon style, colorful, friendly, animated style',
            'photography' => 'professional photography, well lit, high resolution, commercial photography',
            'abstract' => 'abstract art, creative, unique design, artistic interpretation'
        ];
        
        $styleInstruction = $styleInstructions[$style] ?? 'high quality, professional';
        
        return $prompt . ', ' . $styleInstruction . ', service related imagery, clean background';
    }

    /**
     * Save image locally from URL
     */
    protected function saveImageLocally(string $imageUrl, string $prompt): string
    {
        try {
            // Download the image
            $imageContent = Http::get($imageUrl)->body();
            
            // Generate filename
            $filename = 'ai_generated_' . Str::slug(Str::limit($prompt, 50)) . '_' . time() . '.png';
            $path = 'ai_images/' . $filename;
            
            // Ensure directory exists
            $directory = dirname($path);
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            // Save to storage using public disk
            Storage::disk('public')->put($path, $imageContent);
            
            // Return public URL with custom domain structure
            $storageUrl = Storage::disk('public')->url($path);
            // For this domain, images need to be accessible via /public/storage/
            return str_replace('/storage/', '/public/storage/', $storageUrl);
            
        } catch (\Exception $e) {
            Log::error('Failed to save image locally: ' . $e->getMessage());
            // Return original URL if local save fails
            return $imageUrl;
        }
    }

    /**
     * Alternative image generation using Stability AI (Stable Diffusion)
     */
    public function generateImageWithStabilityAI(string $prompt, array $options = []): array
    {
        try {
            $apiKey = config('services.stability.api_key', env('STABILITY_API_KEY'));
            
            Log::info('Stability AI key check', [
                'config_key' => config('services.stability.api_key'),
                'env_key' => env('STABILITY_API_KEY'),
                'final_key' => $apiKey,
                'key_length' => $apiKey ? strlen($apiKey) : 0
            ]);
            
            if (!$apiKey) {
                return [
                    'success' => false,
                    'error' => 'Stability AI API key not configured'
                ];
            }

            $style = $options['style'] ?? 'realistic';
            $size = $options['size'] ?? '1024x1024';
            
            // Parse size
            [$width, $height] = explode('x', $size);
            
            $enhancedPrompt = $this->enhancePrompt($prompt, $style);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => config('app.env') !== 'local', // Only disable SSL verification in local development
                'timeout' => config('services.stability.timeout', 120),
            ])->post('https://api.stability.ai/v1/generation/stable-diffusion-xl-1024-v1-0/text-to-image', [
                'text_prompts' => [
                    [
                        'text' => $enhancedPrompt,
                        'weight' => 1
                    ]
                ],
                'cfg_scale' => 7,
                'height' => (int) $height,
                'width' => (int) $width,
                'samples' => 1,
                'steps' => 30,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['artifacts'][0]['base64'])) {
                    $base64Image = $data['artifacts'][0]['base64'];
                    
                    // Save base64 image locally
                    $localImagePath = $this->saveBase64Image($base64Image, $prompt);
                    
                    return [
                        'success' => true,
                        'image_url' => $localImagePath,
                        'prompt' => $enhancedPrompt,
                        'style' => $style,
                        'size' => $size
                    ];
                }
            }

            return [
                'success' => false,
                'error' => 'فشل في توليد الصورة باستخدام Stability AI'
            ];

        } catch (\Exception $e) {
            Log::error('Stability AI Image Generation Exception: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => 'حدث خطأ أثناء توليد الصورة: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Save base64 image locally
     */
    protected function saveBase64Image(string $base64Image, string $prompt): string
    {
        try {
            // Debug logging
            Log::info('saveBase64Image called', [
                'prompt' => $prompt,
                'base64_length' => strlen($base64Image)
            ]);
            
            // Decode base64
            $imageContent = base64_decode($base64Image);
            
            // Generate filename
            $filename = 'ai_generated_' . Str::slug(Str::limit($prompt, 50)) . '_' . time() . '.png';
            $path = 'ai_images/' . $filename;
            
            // Ensure directory exists
            $directory = dirname($path);
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            // Save to storage using public disk
            Storage::disk('public')->put($path, $imageContent);
            
            // Return public URL with custom domain structure
            $storageUrl = Storage::disk('public')->url($path);
            // For this domain, images need to be accessible via /public/storage/
            return str_replace('/storage/', '/public/storage/', $storageUrl);
            
        } catch (\Exception $e) {
            Log::error('Failed to save base64 image locally: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate image with multiple services fallback
     */
    protected function generateWithMultipleServices(string $prompt, string $size, string $quality): array
    {
        // Try Stability AI first (primary service for Claude-enhanced generation)
        $stabilityResult = $this->generateImageWithStabilityAI($prompt, ['size' => $size]);
        if ($stabilityResult['success']) {
            return array_merge($stabilityResult, ['service' => 'Stability AI']);
        }
        
        Log::info('Stability AI failed, trying OpenAI', ['error' => $stabilityResult['error'] ?? 'Unknown error']);
        
        // Fallback to OpenAI DALL-E if available
        if ($this->apiKey) {
            $openAIResult = $this->generateImageWithOpenAI($prompt, $size, $quality);
            if ($openAIResult['success']) {
                return array_merge($openAIResult, ['service' => 'OpenAI DALL-E']);
            }
        } else {
            $openAIResult = ['success' => false, 'error' => 'OpenAI API key not configured'];
        }
        
        // Both services failed - provide enhanced prompt as fallback
        return [
            'success' => false,
            'error' => 'خدمات توليد الصور غير متاحة. يرجى إضافة API key لـ OpenAI أو Stability AI في ملف .env',
            'enhanced_prompt' => $prompt,
            'suggestion' => 'يمكنك استخدام الوصف المُحسن أدناه مع أي خدمة توليد صور أخرى',
            'details' => [
                'stability_error' => $stabilityResult['error'] ?? 'API key not configured',
                'openai_error' => $openAIResult['error'] ?? 'API key not configured'
            ]
        ];
    }
    
    /**
     * Generate image using OpenAI DALL-E
     */
    protected function generateImageWithOpenAI(string $prompt, string $size, string $quality): array
    {
        try {
            if (!$this->apiKey) {
                return [
                    'success' => false,
                    'error' => 'OpenAI API key not configured'
                ];
            }
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => config('app.env') !== 'local', // Only disable SSL verification in local development
                'timeout' => config('services.openai.timeout', 120),
            ])->post($this->baseUrl . '/images/generations', [
                'model' => 'dall-e-3',
                'prompt' => $prompt,
                'size' => $size,
                'quality' => $quality,
                'n' => 1,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data'][0]['url'])) {
                    return [
                        'success' => true,
                        'image_url' => $data['data'][0]['url'],
                        'usage' => $data['usage'] ?? []
                    ];
                }
            }
            
            $errorMessage = $response->json()['error']['message'] ?? 'Unknown OpenAI error';
            return [
                'success' => false,
                'error' => $errorMessage
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'OpenAI request failed: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Validate API key
     */
    public function validateApiKey(): bool
    {
        try {
            if (!$this->apiKey) {
                return false;
            }

            // Test with a simple request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/models');

            return $response->successful();
            
        } catch (\Exception $e) {
            Log::error('API Key validation failed: ' . $e->getMessage());
            return false;
        }
    }
}