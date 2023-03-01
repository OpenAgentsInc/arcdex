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
    },
    success: function(file, response) {
      console.log(file, response);
        console.log(response.url)
    },
  }
</script>
