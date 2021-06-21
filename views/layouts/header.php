<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manager Note</title>
    <!--  CSS  -->
    <link href="/tailwind.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="container mx-auto">

        <nav class="mx-auto bg-blue-300">
            <!-- If user authentication -->
            <?php if (isset($_SESSION['user_session'])) { ?>
                <ul class="flex flex-row mx-auto text-center justify-end">
                    <li><p class="p-1 m-1"><?php echo $_SESSION['user_session']['email'] ?></p></li>
                    <li>
                        <form action=".?action=logout" method="post">
                            <input type="submit" value="Logout"
                                   class="bg-yellow-300 cursor-pointer transition hover:bg-yellow-500 focus:bg-green-300 rounded-sm p-1 m-1">
                        </form>
                    </li>
                </ul>
                <!-- Else -->
            <?php } else { ?>
                <ul class="flex flex-row mx-auto text-center justify-end">
                <li class="p-2"><a href=".?action=login">Login</a></li>
                <li class="p-2"><a href=".?action=register">Register</a></li>
                </ul>
            <?php } ?>

            <!--Nav-->
            <ul class="flex flex-row mx-auto text-center justify-left">
                <li class="p-2"><a href=".?action=home">Home</a></li>
                <?php if (isset($_SESSION['user_session'])) { ?>
                    <li class="p-2"><a href=".?action=list_notes">My notes</a></li>
                    <li class="p-2"><a href=".?action=create_note">Create Note</a></li>
                    <li class="p-2"><a href=".?action=upload_notes">Upload your notes</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>
<main>

