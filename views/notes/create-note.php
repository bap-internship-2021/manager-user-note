<?php
require_once './views/layouts/header.php'; // header
?>

    <!--Main-->
    <div class="container mx-auto mt-5">
        <section>
            <h1 class="text-blue-300 text-5xl text-center">Create new note</h1>
            <form class="w-full  mx-auto mt-3 border-2 border-blue-300 rounded-md flex flex-col"
                  style="height: 500px"
                  action=".?action=handle_store_note"
                  method="POST">
                <input type="text" name="title" placeholder="Enter your title"
                       class="bg-gray-100 my-10 focus:bg-white border border-black rounded-md w-4/5 mx-auto p-0">
                <!-- Title error -->
                <?php if (isset($_SESSION['note']['titleError'])) { ?>
                    <p class="text-center text-red-500"><?php echo $_SESSION['note']['titleError'] ?></p>
                    <?php unset($_SESSION['note']['titleError']);
                } ?>
                <lable for="content" class="text-center text-2xl cursor-pointer">Enter content</lable>
                <textarea id="content"
                          name="content"
                          rows="50"
                          cols="100"
                          class="resize-none border border-black  rounded-md bg-gray-100 my-10 h-full focus:bg-white w-4/5 mx-auto py-1">
                </textarea>
                <!-- Content error -->
                <?php if (isset($_SESSION['note']['contentError'])) { ?>
                    <p class="text-center text-red-500"><?php echo $_SESSION['note']['contentError'] ?></p>
                    <?php unset($_SESSION['note']['contentError']);
                } ?>
                <!-- Button submit -->
                <input type="submit" value="Create"
                       class="bg-blue-300 border border-black rounded-md w-1/5 mx-auto p-2 my-3 hover:bg-blue-400">
            </form>
        </section>
    </div>

<?php
require_once './views/layouts/footer.php'; // footer
?>