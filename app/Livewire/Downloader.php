<?php

namespace App\Livewire;

use Livewire\Component;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Downloader extends Component
{
    public $url;
    public $downloadType = 'video';
    public $isDownloading = false;

    public function download()
    {
        $this->validate([
            'url' => 'required|url',
            'downloadType' => 'required|in:video,audio'
        ]);

        $this->isDownloading = true;

        $scriptPath = public_path('scripts\download.py');

        $process = new Process([
            'python',
            $scriptPath,
            $this->url,
            $this->downloadType
        ]);

        try {
            $process->mustRun();

            if ($process->isSuccessful()) {
                session()->flash('message', 'Descarga completada en public/downloads');
            } else {
                $errorOutput = $process->getErrorOutput();
                session()->flash('error', 'Error: ' . explode('error:', $errorOutput)[1] ?? $errorOutput);
            }

        } catch (ProcessFailedException $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        } finally {
            $this->isDownloading = false;
        }
    }

    public function render()
    {
        return view('livewire.downloader');
    }
}