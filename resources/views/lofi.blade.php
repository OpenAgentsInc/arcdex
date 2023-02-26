    <title>Arc</title>
    <link rel="icon" href="/img/logo.png" type="image/png" sizes="16x16">

<!-- pull in tailwind from cdn -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="h-screen w-screen bg-gray-800 flex flex-col justify-center items-center">

<!-- HTML audio player -->
<audio id="my-audio" controls autoplay>
    Your browser does not support the audio element.
</audio>

<div class="mt-6">
  <div class="bg-gray-100 rounded-lg shadow-lg p-4">
    <div class="flex flex-col md:flex-row items-center">
      <div class="flex-shrink-0">
        <img class="h-12 w-12 rounded-full" src="/img/lofi.jpeg" alt="Lofi Girl">
      </div>
      <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
        <p class="text-lg leading-tight font-semibold text-gray-900">Thank you Lofi Girl and Kupla for the music!</p>
              <p class="text-gray-600">All music from <a href="https://lofigirl.com" target="_blank" class="text-blue-500 hover:text-blue-600">Lofi Girl</a>
              and <a href="https://lofigirl.com/blogs/artist/kupla" target="_blank" class="text-blue-500 hover:text-blue-600">Kupla</a>.</p>
      </div>
    </div>
  </div>
</div>

</div>

<script>
  const audio = document.getElementById("my-audio");
  const mp3Files = [
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/01%20Kupla%20-%20Eons%20%28master%29.mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/02 Kupla - Heroes (master 5).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/03 Kupla - A Waltz for My Best Friend (master 2).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/04 Kupla - Magic (master6).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/05 Kupla - Soft to Touch (first master).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/06 Kupla - Those Were the Days (master).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/07 Kupla - Mycelium (master).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/08 Kupla - Weightless (Master).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/09 Kupla - Microscopic (Master).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/10 Kupla - Distant Lands (master).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/11 Kupla - Natural Ways (master 2).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/12 Kupla - Purple Vision (master).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/13 Kupla - Twilight (master).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/14 Kupla - Sylvan (master 2).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/15 Kupla - Last Walk (master 2).mp3",
    "https://d22hdgrsmzgwgk.cloudfront.net/lofi/16 Kupla - Safe Haven (Master).mp3",
  ];
  
  let currentTrackIndex = 0; // Keep track of the index of the currently playing track

  function playNextTrack() {
    currentTrackIndex++;
    if (currentTrackIndex >= mp3Files.length) {
      currentTrackIndex = 0;
    }
    audio.src = mp3Files[currentTrackIndex];
    audio.play();
  }

  // Add an event listener to detect when the current track has ended
  audio.addEventListener("ended", function() {
    playNextTrack();
  });

  // Play the first track
  playNextTrack();
</script>
