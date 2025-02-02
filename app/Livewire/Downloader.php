<?php

namespace App\Livewire;

use App\Models\Download;
use Livewire\Component;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Downloader extends Component
{
    public $url;
    public $downloadType = 'video';

    public function download()
    {
        $this->validate([
            'url' => 'required|url',
            'downloadType' => 'required|in:video,audio'
        ]);

        // Determinar qué script usar
        $scriptName = $this->downloadType === 'video'
            ? 'Video.py'
            : 'Audio.py';

        // Ajustar ruta usando public_path()
        $scriptPath = public_path('scripts' . DIRECTORY_SEPARATOR . $scriptName);

        // Verificar si el archivo existe
        if (!file_exists($scriptPath)) {
            session()->flash('error', __('Error: The download script does not exist'));
            return;
        }

        $download = Download::create([
            'user_id' => auth()->id(),  // o asigna un valor por defecto si no está autenticado
            'url' => $this->url,
            'download_type' => $this->downloadType,
            'selected_format' => '', // o puedes asignar algún valor, si aplica
            'status' => 'pending',
            'message' => __('Download started')
        ]);

        $process = new Process([
            'python',
            $scriptPath,
            $this->url
        ]);

        try {
            $process->setTimeout(300);  // 5 minutos de timeout
            $process->mustRun();

            $message = $this->downloadType === 'video'
                ? __('Video downloaded successfully')
                : __('Audio downloaded successfully');

            $download->update([
                'status' => 'completed',
                'message' => $message
            ]);

            session()->flash('message', $message);
        } catch (ProcessFailedException $exception) {
            // Mejor manejo de errores incluyendo salida del script
            $errorOutput = $exception->getProcess()->getErrorOutput();

            $error = match (true) {
                str_contains($errorOutput, 'Unsupported URL') => __('Invalid or unsupported URL'),
                str_contains($errorOutput, 'FFmpeg') => __('Error processing file: Verify that FFmpeg is installed'),
                str_contains($errorOutput, 'error:') => __('Download error: ') . explode('error:', $errorOutput)[1],
                default => __('Unknown error: ') . $errorOutput
            };

            $download->update([
                'status' => 'failed',
                'message' => $error
            ]);

            session()->flash('error', $error);
        }
    }

    public function render()
    {
        return view('livewire.downloader');
    }
}