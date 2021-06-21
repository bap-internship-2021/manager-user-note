<?php
require_once './views/layouts/header.php'; // header
?>

    <!--Main-->
    <div class="container mx-auto mt-5">
        <!-- Delete success -->
        <?php if (!empty($_SESSION['Delete']['success'])) { ?>
            <p class="text-green-500"><?php echo $_SESSION['Delete']['success'] ?></p>
            <?php unset($_SESSION['Delete']['success']);
        } ?>
        <!-- Delete fail -->
        <?php if (!empty($_SESSION['Delete']['fail'])) { ?>
            <p class="text-red-500"><?php echo $_SESSION['Delete']['fail'] ?></p>
            <?php unset($_SESSION['Delete']['fail']);
        } ?>
        <table class="table-auto w-full">
            <thead>
            <tr class="bg-blue-500">
                <th>NO.</th>
                <th class="truncate">Title</th>
                <th class="truncate">Content</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            <!-- Check if notes not empty then display note -->
            <?php if (!empty($notes)) { ?>
                <?php foreach ($notes as $key => $note) { ?>
                    <tr class="bg-blue-200">
                        <td><?php echo $key ?></td>
                        <td><?php echo $note['title'] ?></td>
                        <td><?php echo $note['content'] ?></td>
                        <td><a href=".?action=edit_note&id=<?php echo $note['id'] ?>" class="text-yellow-800">Edit</a>
                        </td>
                        <td>
                            <form action=".?action=delete" method="post">
                                <input type="hidden" value="<?php echo $note['id'] ?>" name="id">
                                <input type="submit" value="Delete">
                            </form>
                        </td>
                        <td><a href="<?php echo $note['path']; ?>">Download</a></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php
require_once './views/layouts/footer.php'; // footer
?>