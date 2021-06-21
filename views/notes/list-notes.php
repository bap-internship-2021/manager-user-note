<?php
require_once './views/layouts/header.php'; // header
?>

    <!--Main-->
    <div class="container mx-auto mt-5">
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
                        <td>Delete</td>
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