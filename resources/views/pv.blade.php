<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<link
  rel="stylesheet"
  href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
  type="text/css"
/>

<div class="text-center max-w-lg">
    <form action="{{ url('upload') }}"
          class="dropzone"
          id="my-dropzone">
          @csrf
          <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Title:</label>
            <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="subtitle" class="block text-gray-700 font-bold mb-2">Subtitle:</label>
            <input type="text" name="subtitle" id="subtitle" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="series_name" class="block text-gray-700 font-bold mb-2">Series Name:</label>
            <input type="text" name="series_name" id="series_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="episode_number" class="block text-gray-700 font-bold mb-2">Episode Number:</label>
            <input type="number" name="episode_number" id="episode_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <input type="file" name="file"  style="display: none;">
    </form>
    <ul id="file-upload-list" class="list-unstyled">
    </ul>
</div>

<script>
  Dropzone.options.myDropzone = {
    maxFilesize: 1212500,
    init: function() {
      this.on("uploadprogress", function(file, progress) {
        console.log("File progress", progress);
      });
    }
  }
</script>
