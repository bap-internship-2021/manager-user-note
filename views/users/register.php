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
                <?php if (isset($_SESSION['register_error']['email'])) { ?>
                    <p class="text-red-500 text-center"><?php echo $_SESSION['register_error']['email'] ?></p>
                    <?php unset($_SESSION['register_error']['email']);
                } ?>
                <!-- Name-->
                <lable for="name" class="w-3/5 mx-auto mt-3">Name</lable>
                <input type="text" name="name"
                       class="bg-gray-200 focus:bg-white border border-black rounded-md w-3/5 mx-auto p-2">
                <?php if (isset($_SESSION['register_error']['name'])) { ?>
                    <p class="text-red-500 text-center"><?php echo $_SESSION['register_error']['name'] ?></p>
                    <?php unset($_SESSION['register_error']['name']);
                } ?>
                <lable for="phone" class="w-3/5 mx-auto mt-3">Phone</lable>
                <input type="text" name="phone"
                       class="bg-gray-200 focus:bg-white border border-black rounded-md w-3/5 mx-auto p-2">
                <?php if (isset($_SESSION['register_error']['phone'])) { ?>
                    <p class="text-red-500 text-center"><?php echo $_SESSION['register_error']['phone'] ?></p>
                    <?php unset($_SESSION['register_error']['phone']);
                } ?>

                <lable for="password" class="w-3/5 mx-auto mt-3">Password</lable>
                <input type="password" name="password"
                       class="bg-gray-200 focus:bg-white border border-black rounded-md w-3/5 mx-auto p-2">
                <?php if (isset($_SESSION['register_error']['password'])) { ?>
                    <p class="text-red-500 text-center"><?php echo $_SESSION['register_error']['password'] ?></p>
                    <?php unset($_SESSION['register_error']['password']);
                } ?>

                <lable for="password_confirmation" class="w-3/5 mx-auto mt-3">Password confirmation</lable>
                <input type="password" name="password_confirmation"
                       class="bg-gray-200 focus:bg-white border border-black rounded-md w-3/5 mx-auto p-2">
                <?php if (isset($_SESSION['register_error']['password_confirmation'])) { ?>
                    <p class="text-red-500 text-center"><?php echo $_SESSION['register_error']['password_confirmation'] ?></p>
                    <?php unset($_SESSION['register_error']['password_confirmation']);
                } ?>

                <!-- Button submit -->
                <input type="submit" value="Register"
                       class="bg-blue-300 border border-black rounded-md w-1/5 mx-auto p-2 my-3 hover:bg-blue-400">
            </form>
            <!-- success register -->
            <?php if (isset($_SESSION['register_success'])) {  ?>
                <p class="text-green-500 text-center">Register success!</p>
            <?php } ?>
            <!-- If Email has been register-->
            <?php if (isset($_SESSION['email_exists'])) { ?>
                <p class="text-red-500 text-center"><?php echo $_SESSION['email_exists'] ?></p>
                <?php unset($_SESSION['email_exists']);
            } ?>
            <!-- Something went wrong-->
            <?php if (isset($_SESSION['register_message'])) { ?>
                <p class="text-red-500 text-center"><?php echo $_SESSION['register_message'] ?></p>
                <?php unset($_SESSION['register_message']);
            } ?>

        </section>
    </div>

<?php
require_once './views/layouts/footer.php'; // footer
?>