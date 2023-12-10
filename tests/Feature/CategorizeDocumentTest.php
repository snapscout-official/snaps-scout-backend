<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $sampleFilePath = Storage::path('SnapScout-2.xlsx');
        $fakeFile = UploadedFile::fake()->createWithContent('snapscout.xlsx', file_get_contents($sampleFilePath));
        dd($fakeFile);
        $response = $this->actingAs($user)
            ->withoutExceptionHandling()
            ->post('/api/agency/upload/document', ['document' => $fakeFile]);
        
        $response->assertStatus(500);
        Storage::disk('TestSnap')->assertExists('SnapScout-2-2.xlsx');
    }
}
