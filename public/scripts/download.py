import sys
import yt_dlp as ydl
from pathlib import Path

url, tipo = sys.argv[1], sys.argv[2]
script_path = Path(__file__).resolve().parent
download_dir = script_path.parent / "downloads"

# Crear directorio de descargas con permisos adecuados
download_dir.mkdir(parents=True, exist_ok=True)

# Configurar opciones para Windows
opts = {
    'outtmpl': str(download_dir / '%(title)s.%(ext)s'),
    'windowsfilenames': True,
    'quiet': True,
    'noplaylist': True,
    'format': 'bestvideo[ext=mp4]+bestaudio/best' if tipo == 'video' else 'bestaudio/best',
    'postprocessors': []
}

if tipo == 'audio':
    opts['postprocessors'].append({
        'key': 'FFmpegExtractAudio',
        'preferredcodec': 'mp3',
        'preferredquality': '192',
    })
elif tipo == 'video':
    opts['postprocessors'].append({
        'key': 'FFmpegVideoConvertor',
        'preferedformat': 'mp4',
    })

try:
    with ydl.YoutubeDL(opts) as ydl_client:
        ydl_client.download([url])
    print("success")
except Exception as e:
    print(f"error: {str(e)}")