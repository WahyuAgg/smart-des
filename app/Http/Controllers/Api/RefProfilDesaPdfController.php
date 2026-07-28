<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RefProfilDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RefProfilDesaPdfController extends Controller
{
    /**
     * Upload or update the PDF file for a RefProfilDesa record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RefProfilDesa  $refProfilDesa
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, RefProfilDesa $refProfilDesa)
    {
        $request->validate([
            'peta_pdf' => 'required|file|mimes:pdf|max:2048', // 2MB max
        ]);

        // Delete old file if exists
        if ($refProfilDesa->peta_pdf && Storage::disk('public')->exists($refProfilDesa->peta_pdf)) {
            Storage::disk('public')->delete($refProfilDesa->peta_pdf);
        }

        // Store the new file
        $path = $request->file('peta_pdf')->store('peta_pdf', 'public');

        // Update the model
        $refProfilDesa->update([
            'peta_pdf' => $path,
        ]);

        return response()->json([
            'message' => 'PDF uploaded successfully',
            'path' => $path,
        ]);
    }

    /**
     * Retrieve the PDF file URL.
     *
     * @param  \App\Models\RefProfilDesa  $refProfilDesa
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(RefProfilDesa $refProfilDesa)
    {
        if (!$refProfilDesa->peta_pdf || !Storage::disk('public')->exists($refProfilDesa->peta_pdf)) {
            return response()->json(['message' => 'PDF not found'], 404);
        }

        return response()->json([
            'url' => Storage::disk('public')->url($refProfilDesa->peta_pdf),
        ]);
    }

    /**
     * Delete the PDF file.
     *
     * @param  \App\Models\RefProfilDesa  $refProfilDesa
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(RefProfilDesa $refProfilDesa)
    {
        if ($refProfilDesa->peta_pdf && Storage::disk('public')->exists($refProfilDesa->peta_pdf)) {
            Storage::disk('public')->delete($refProfilDesa->peta_pdf);
            $refProfilDesa->update(['peta_pdf' => null]);
        }

        return response()->json(['message' => 'PDF deleted successfully']);
    }
}