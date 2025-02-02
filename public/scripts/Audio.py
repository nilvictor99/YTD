import sys
import yt_dlp as ydl
from pathlib import Path

url = sys.argv[1] 
script_path = Path(__file__).resolve().parent
download_dir = script_path.parent / "Audio"


download_dir.mkdir(parents=True, exist_ok=True)


opts = {
    'outtmpl': str(download_dir / '%(title)s.%(ext)s'),
    'windowsfilenames': True,
    'quiet': True,
    'noplaylist': True,
    'format': 'bestaudio/best',
    'postprocessors': [{
        'key': 'FFmpegExtractAudio',
        'preferredcodec': 'mp3',
        'preferredquality': '320',
    }]
}

try:
    with ydl.YoutubeDL(opts) as ydl_client:
        ydl_client.download([url])
    print("success")
except Exception as e:
    print(f"error: {str(e)}")