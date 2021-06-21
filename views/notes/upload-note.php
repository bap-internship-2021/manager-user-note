<?php
require_once './views/layouts/header.php'; // header
?>

    <!--Main-->
    <div class="container mx-auto mt-5">
        <section>
            <h1 class="text-blue-300 text-5xl text-center">Upload your notes</h1>
            <form class="w-3/5  mx-auto mt-3 border-2 border-blue-300 rounded-md flex flex-col"
                  action=".?action=handle_upload_notes"
                  method="POST" enctype="multipart/form-data">

                <input type="file" name="files[]" class="mx-auto mt-5" multiple="multiple">
                <!-- Button submit -->
                <input type="submit" value="Upload"
                       class="bg-blue-300 border border-black rounded-md w-1/5 mx-auto p-2 my-3 hover:bg-blue-400">
            </form>
        </section>
    </div>

<?php
require_once './views/layouts/footer.php'; // footer
?>