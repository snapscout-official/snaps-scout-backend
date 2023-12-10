<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class CategorizeDocumentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_categorize_api_returns_correct_status_code()
    {   
        $response = $this->post('/api/agency/categorize/document', ['document_name' => 'SnapScout-2.xlsx']);
        $response->assertStatus(201);
    }
    public function test_can_upload_xlsx_file() 
    {
        Storage::fake('TestSnap');
        Excel::fake();
        $user = User::find(2);   
        $file = UploadedFile::fake()->create('snapscout.xlsx');
        $response = $this->actingAs($user)->post('/api/agency/upload/document', ['document' => $file]);
        $response->assertStatus(201);
        Storage::disk('TestSnap')->assertExists($file->getClientOriginalName());
    }
}
