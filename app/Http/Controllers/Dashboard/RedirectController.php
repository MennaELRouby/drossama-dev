<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use App\Services\Dashboard\RedirectService;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    protected $service;

    public function __construct(RedirectService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $redirects = $this->service->list();
        return view('Dashboard.Redirects.index', compact('redirects'));
    }

    public function create()
    {
        return view('Dashboard.Redirects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'source' => 'required|string|max:2048|unique:redirects,source',
            'target' => 'nullable|string|max:2048',
            'status_code' => 'required|in:301,302,410',
            'is_active' => 'sometimes|boolean',
            'notes' => 'nullable|string|max:255',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $this->service->create($data);
        return redirect()->route('dashboard.redirects.index')->with('success', 'Redirect saved');
    }

    public function edit(Redirect $redirect)
    {
        return view('Dashboard.Redirects.edit', compact('redirect'));
    }

    public function update(Request $request, Redirect $redirect)
    {
        $data = $request->validate([
            'source' => 'required|string|max:2048|unique:redirects,source,' . $redirect->id,
            'target' => 'nullable|string|max:2048',
            'status_code' => 'required|in:301,302,410',
            'is_active' => 'sometimes|boolean',
            'notes' => 'nullable|string|max:255',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $this->service->update($redirect, $data);
        return redirect()->route('dashboard.redirects.index')->with('success', 'Redirect updated');
    }

    public function destroy(Redirect $redirect)
    {
        $this->service->delete($redirect);
        return redirect()->route('dashboard.redirects.index')->with('success', 'Redirect deleted');
    }

    public function importForm()
    {
        return view('Dashboard.Redirects.import');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="redirects_template.csv"',
        ];
        $content = "source,target,status_code,is_active,notes\n/en/old-url,https://example.com/en/new-url,301,1,optional note\n/en/removed,,410,1,removed permanently\n";
        return response($content, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
            'default_status' => 'nullable|in:301,302,410',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $defaultStatus = (int)($request->input('default_status') ?: 301);
        $inserted = 0;
        $updated = 0;
        $errors = [];

        if (($handle = fopen($path, 'r')) !== false) {
            $rowNum = 0;
            while (($row = fgetcsv($handle)) !== false) {
                $rowNum++;
                if ($rowNum === 1 && isset($row[0]) && stripos($row[0], 'source') !== false) {
                    continue; // skip header
                }
                // Expecting: source, target, status_code, is_active, notes
                $source = trim($row[0] ?? '');
                $target = trim($row[1] ?? '');
                $status = (int)trim((string)($row[2] ?? $defaultStatus));
                $active = trim((string)($row[3] ?? '1'));
                $notes = trim($row[4] ?? '');

                if ($source === '') {
                    $errors[] = "Row {$rowNum}: missing source";
                    continue;
                }
                if (!in_array($status, [301, 302, 410], true)) {
                    $status = $defaultStatus;
                }
                if ($status !== 410 && $target === '') {
                    $errors[] = "Row {$rowNum}: target required for status {$status}";
                    continue;
                }
                try {
                    $existing = Redirect::where('source', $source)->first();
                    $data = [
                        'target' => $target !== '' ? $target : null,
                        'status_code' => $status,
                        'is_active' => in_array(strtolower($active), ['1', 'true', 'yes', 'y'], true),
                        'notes' => $notes ?: null,
                    ];
                    if ($existing) {
                        $existing->update($data);
                        $updated++;
                    } else {
                        $this->service->create(array_merge(['source' => $source], $data));
                        $inserted++;
                    }
                } catch (\Throwable $e) {
                    $errors[] = "Row {$rowNum}: " . $e->getMessage();
                }
            }
            fclose($handle);
        }

        $msg = "Imported: {$inserted}, Updated: {$updated}";
        return redirect()->route('dashboard.redirects.index')->with([
            'success' => $msg,
            'import_errors' => $errors,
        ]);
    }
}