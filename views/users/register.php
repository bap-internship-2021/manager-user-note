<?php
require_once './views/layouts/header.php'; // header
?>

    <!--Main-->
    <div class="container mx-auto mt-5">
        <section>
            <h1 class="text-blue-300 text-5xl text-center">Register</h1>
            <form class="w-3/5 mx-auto mt-3 border-2 border-blue-300 rounded-md flex flex-col"
                  action=".?action=handle_register"
                  method="POST">
                <lable for="email" class="w-3/5 mx-auto mt-3">Email</lable>
                <input type="text" name="email"
                       class="bg-gray-200 focus:bg-white border border-black rounded-md w-3/5 mx-auto p-2">

                <!-- Name-->
                <lable for="name" class="w-3/5 mx-auto mt-3">Name</lable>
                <input type="text" name="name"
                       class="bg-gray-200 focus:bg-white border border-black rounded-md w-3/5 mx-auto p-2">

                <lable for="phone" class="w-3/5 mx-auto mt-3">Phone</lable>
                <input type="text" name="phone"
                       class="bg-gray-200 focus:bg-white border border-black rounded-md w-3/5 mx-auto p-2">

                <lable for="password" class="w-3/5 mx-auto mt-3">Password</lable>
                <input type="password" name="password"
                       class="bg-gray-200 focus:bg-white border border-black rounded-md w-3/5 mx-auto p-2">

                <lable for="password_confirmation" class="w-3/5 mx-auto mt-3">Password confirmation</lable>
                <input type="password" name="password_confirmation"
                       class="bg-gray-200 focus:bg-white border border-black rounded-md w-3/5 mx-auto p-2">
                <!-- Button submit -->
                <input type="submit" value="Register"
                       class="bg-blue-300 border border-black rounded-md w-1/5 mx-auto p-2 my-3 hover:bg-blue-400">
            </form>

            <?php if (!empty($error)) { ?>
                <p class="text-red-500 text-center">Register fail, please try again!</p>
            <?php } ?>
        </section>
    </div>

<?php
require_once './views/layouts/footer.php'; // footer
?>