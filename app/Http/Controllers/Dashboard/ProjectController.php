<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Projects\DeleteProjectRequest;
use App\Http\Requests\Dashboard\Projects\StoreProjectRequest;
use App\Http\Requests\Dashboard\Projects\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Category;
use App\Models\ProjectImage;
use App\Services\Dashboard\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{

    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->authorize('projects.view');
            $projects = Project::with('parent')->orderBy('id', 'desc')->get();
            Log::info('Projects index accessed successfully', ['count' => $projects->count()]);
            return view('Dashboard.Projects.index', compact('projects'));
        } catch (\Exception $e) {
            Log::error('Error accessing projects index: ' . $e->getMessage());
            return redirect()->back()->withErrors(__('dashboard.an error has occurred'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $this->authorize('projects.create');
            $data['project'] = new Project();
            $data['projects'] = Project::with('parent')->get();
            $data['categories'] = Category::with('parent')->get();
            Log::info('Project create form accessed successfully');
            return view('Dashboard.Projects.create', $data);
        } catch (\Exception $e) {
            Log::error('Error accessing project create form: ' . $e->getMessage());
            return redirect()->back()->withErrors(__('dashboard.an error has occurred'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('projects.store');
        try {
            $data = $request->validated();
            Log::info('Creating new project', ['data' => Arr::except($data, ['image', 'icon', 'project_images'])]);

            $response = $this->projectService->store($request, $data);

            if (!$response) {
                Log::warning('Failed to create project');
                return redirect()->back()->with(['error' => __('dashboard.failed_to_create_item')]);
            }

            Log::info('Project created successfully', ['project_id' => $response->id]);
            return redirect()->route('dashboard.projects.index')->with(['success' => __('dashboard.your_item_created_successfully')]);
        } catch (\Exception $e) {
            Log::error('Error creating project: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        try {
            $this->authorize('projects.edit');
            $data['project'] = $project;
            $data['projects'] = Project::with('parent')->get();
            $data['categories'] = Category::with('parent')->get();
            Log::info('Project edit form accessed successfully', ['project_id' => $project->id]);
            return view('Dashboard.Projects.edit', $data);
        } catch (\Exception $e) {
            Log::error('Error accessing project edit form: ' . $e->getMessage());
            return redirect()->back()->withErrors(__('dashboard.an error has occurred'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('projects.update');
        try {
            $data = $request->validated();
            Log::info('Updating project', [
                'project_id' => $project->id,
                'data' => Arr::except($data, ['image', 'icon', 'project_images'])
            ]);

            $response = $this->projectService->update($request, $project);

            if (!$response) {
                Log::warning('Failed to update project', ['project_id' => $project->id]);
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }

            Log::info('Project updated successfully', ['project_id' => $project->id]);
            return redirect()->route('dashboard.projects.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {
            Log::error('Error updating project: ' . $e->getMessage(), ['project_id' => $project->id]);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteProjectRequest $request, $project)
    {
        try {
            $this->authorize('projects.delete');

            Log::info('Starting delete operation in ProjectController', [
                'id' => $id,
                'request' => $request->all(),
                'request_method' => $request->method(),
                'request_url' => $request->url(),
                'request_headers' => $request->headers->all()
            ]);

            $selectedIds = $request->input('selectedIds', [$project]);

            Log::info('Processing delete request', [
                'selectedIds' => $selectedIds,
                'validated_data' => $request->validated()
            ]);

            try {
                $deleted = $this->projectService->delete($selectedIds);

                Log::info('Delete operation completed in ProjectController', [
                    'success' => $deleted,
                    'selectedIds' => $selectedIds
                ]);

                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => __('dashboard.your_items_deleted_successfully')
                    ]);
                }

                return redirect()->back()
                    ->with('success', __('dashboard.your_items_deleted_successfully'));
            } catch (\Exception $e) {
                Log::error('Error in ProjectService@delete', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'selectedIds' => $selectedIds
                ]);

                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error in ProjectController@destroy', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
                'id' => $id
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('dashboard.an_error_occurred')
                ], 500);
            }

            return redirect()->back()
                ->withErrors(__('dashboard.an_error_occurred'));
        }
    }

    /**
     * Change the category of a project.
     */
    public function changeCategory(Request $request, $id)
    {
        try {
            $this->authorize('projects.update');
            $request->validate([
                'category_id' => 'required|exists:categories,id',
            ]);

            $project = Project::findOrFail($id);
            $project->category_id = $request->input('category_id');
            $project->save();

            Log::info('Project category changed successfully', [
                'project_id' => $id,
                'new_category_id' => $request->input('category_id')
            ]);

            return redirect()->back()->with('success', __('dashboard.your_item_updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error changing project category: ' . $e->getMessage(), ['project_id' => $id]);
            return redirect()->back()->withErrors(__('dashboard.an error has occurred'));
        }
    }

    /**
     * Reorder project images using drag and drop
     */
    public function reorderImages(Request $request)
    {
        try {
            $request->validate([
                'image_ids' => 'required|array',
                'image_ids.*' => 'integer|exists:project_images,id',
            ]);

            $imageIds = $request->input('image_ids');
            if (!is_array($imageIds)) {
                Log::warning('Invalid image IDs for reordering', ['image_ids' => $imageIds]);
                return response()->json(['success' => false, 'message' => __('dashboard.invalid_data')], 400);
            }

            foreach ($imageIds as $order => $imageId) {
                ProjectImage::where('id', $imageId)->update(['order' => $order]);
            }

            Log::info('Project images reordered successfully', [
                'count' => count($imageIds),
                'image_ids' => $imageIds
            ]);

            return response()->json(['success' => true, 'message' => __('dashboard.images_reordered_successfully')]);
        } catch (\Exception $e) {
            Log::error('Error reordering project images: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('dashboard.error_reordering_images')], 500);
        }
    }

    /**
     * Remove a specific project image.
     */
    public function destroyImage($id)
    {
        try {
            $image = ProjectImage::findOrFail($id);
            $filename = $image->getImageFilenameAttribute();

            if ($filename) {
                \App\Helper\Media::removeFile('projects', $filename);
                Log::info('Project image file deleted', [
                    'image_id' => $id,
                    'filename' => $filename
                ]);
            }

            $image->delete();
            Log::info('Project image deleted successfully', ['image_id' => $id]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error deleting project image: ' . $e->getMessage(), ['image_id' => $id]);
            return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 500);
        }
    }

    /**
     * Delete all project images
     */
    public function deleteAllImages(Request $request)
    {
        try {
            $projectId = $request->input('project_id');
            $project = Project::findOrFail($projectId);
            $images = $project->images;

            if ($images->isEmpty()) {
                Log::warning('No images found for project', ['project_id' => $projectId]);
                return response()->json(['success' => false, 'message' => __('dashboard.no_images_found')], 404);
            }

            foreach ($images as $image) {
                $filename = $image->getImageFilenameAttribute();
                if ($filename) {
                    \App\Helper\Media::removeFile('projects', $filename);
                    Log::info('Project image file deleted', [
                        'project_id' => $projectId,
                        'image_id' => $image->id,
                        'filename' => $filename
                    ]);
                }
                $image->delete();
            }

            Log::info('All project images deleted successfully', [
                'project_id' => $projectId,
                'count' => $images->count()
            ]);

            return response()->json(['success' => true, 'message' => __('dashboard.all_images_deleted_successfully')]);
        } catch (\Exception $e) {
            Log::error('Error deleting all project images: ' . $e->getMessage(), ['project_id' => $request->input('project_id')]);
            return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 500);
        }
    }

    /**
     * Delete selected project images
     */
    public function deleteSelectedImages(Request $request)
    {
        try {
            $imageIds = $request->input('image_ids');

            if (is_array($imageIds)) {
                foreach ($imageIds as $imageId) {
                    $image = ProjectImage::find($imageId);
                    if ($image) {
                        $filename = $image->getImageFilenameAttribute();
                        if ($filename) {
                            \App\Helper\Media::removeFile('projects', $filename);
                            Log::info('Project image file deleted', [
                                'image_id' => $imageId,
                                'filename' => $filename
                            ]);
                        }
                        $image->delete();
                    }
                }

                Log::info('Selected project images deleted successfully', ['count' => count($imageIds)]);
                return response()->json(['success' => true, 'message' => __('dashboard.selected_images_deleted_successfully')]);
            }

            return response()->json(['success' => false, 'message' => __('dashboard.no_images_selected')], 400);
        } catch (\Exception $e) {
            Log::error('Error deleting selected project images: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 500);
        }
    }

    /**
     * Toggle project status (publish/unpublish)
     */
    public function toggleStatus(Project $project)
    {
        $this->authorize('projects.update');

        try {
            $project->update([
                'status' => $project->status === 1 ? 0 : 1
            ]);

            $message = $project->status === 1
                ? __('dashboard.published_successfully')
                : __('dashboard.unpublished_successfully');

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->back()->with(['success' => $message]);
        } catch (\Exception $e) {
            Log::error('Error toggling project status: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('dashboard.an_error_occurred')
                ], 500);
            }
            return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
        }
    }

    /**
     * Remove multiple resources from storage.
     */
    public function bulkDestroy(Request $request)
    {
        $this->authorize('projects.delete');

        $selectedIds = $request->input('selectedIds');

        if (empty($selectedIds)) {
            return response()->json(['message' => __('dashboard.no_items_selected')], 422);
        }

        try {
            $deleted = $this->service->delete($selectedIds);

            if (request()->ajax()) {
                if (!$deleted) {
                    return response()->json(['message' => __('dashboard.an_error_occurred')], 422);
                }
                return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
            }

            if (!$deleted) {
                return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
            }

            return redirect()->back()->with(['success' => __('dashboard.your_items_deleted_successfully')]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['message' => __('dashboard.an_error_occurred')], 500);
            }
            return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
        }
    }
}
