<?php
session_start();
if(!isset($_SESSION['name']) && $_SESSION['role'] != 'admin'){
    header("Location: login.php");
}
/* ======== Read user ======== */
$fileName = './database/user_list.txt';
$fp = fopen($fileName, 'a+');
$roles = array();
$emails = array();
$passwords = array();
$names = array();

while (!feof($fp)) {
    $line = fgets($fp);
    $userData = explode(",", $line);
    $roles[] = trim($userData[0]);
    $emails[] = trim($userData[1]);
    $passwords[] = trim($userData[2]);
    $names[] = trim($userData[3]);
}
/* ======== Delete user ======== */
$data = file('./database/user_list.txt');
if(isset($_GET['id']) && isset($_GET['id']) != NULL){
    $id = $_GET['id'];
    unset($data[$id]);
    file_put_contents('./database/user_list.txt', $data);
    header("Location: admin-dashboard.php");
}
?>
<?php include 'includes/header.php'; ?>

<div class="p-4 sm:ml-64">
    <div class="p-4 rounded-lg dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white pb-4">Hello <span
                class="text-green-500"><?php echo $_SESSION['name']; ?></span>
        </h2>
        <!-- Card section start -->
        <div class="grid grid-cols-4 gap-4 mb-4">
            <div class="flex flex-col items-center justify-center h-24 rounded bg-teal-500 dark:bg-gray-800">
                <h4 class="text-xl font-bold text-white dark:text-white">Total People</h4>
                <p class="text-3xl font-bold text-white dark:text-white">
                    <?php
                                $data = file('./database/user_list.txt');
                                echo count($data);
                            ?>
                </p>
            </div>
            <div class="flex flex-col items-center justify-center h-24 rounded bg-amber-500 dark:bg-gray-800">
                <h4 class="text-xl font-bold text-white dark:text-white">Admin</h4>
                <p class="text-3xl font-bold text-white dark:text-white">
                    <?php
                                $data = file('./database/user_list.txt');
                                echo count(array_filter($data, function ($line) {
                                    return strpos($line, 'admin') !== false;
                                }))
                            ?>
                </p>
            </div>
            <div class="flex flex-col items-center justify-center h-24 rounded bg-indigo-500 dark:bg-gray-800">
                <h4 class="text-xl font-bold text-white dark:text-white">Manager</h4>
                <p class="text-3xl font-bold text-white dark:text-white">
                    <?php
                                $data = file('./database/user_list.txt');
                                echo count(array_filter($data, function ($line) {
                                    return strpos($line, 'manager') !== false;
                                }));
                            ?>
                </p>
            </div>
            <div class="flex flex-col items-center justify-center h-24 rounded bg-violet-500 dark:bg-gray-800">
                <h4 class="text-xl font-bold text-white dark:text-white">User</h4>
                <p class="text-3xl font-bold text-white dark:text-white">
                    <?php
                                $data = file('./database/user_list.txt');
                                echo count(array_filter($data, function ($line) {
                                    return strpos($line, 'user') !== false;
                                }));
                            ?>
                </p>
            </div>

        </div>
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white pt-4">User List</h2>
            <button class="px-4 py-2 text-white bg-teal-500 rounded-md">
                <a href="add-user.php">Add User</a>
            </button>
        </div>



        <div class="relative overflow-x-auto shadow-md sm:rounded-lg my-3">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($data); $i++){ ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 text-center">
                            # <?php echo $i; ?>
                        </td>
                        <th scope="row"
                            class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?php echo $names[$i]; ?>
                        </th>

                        <td class="px-6 py-4 text-center">
                            <?php echo $emails[$i]; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php echo ucwords($roles[$i]); ?>
                        </td>
                        <td class="px-6 py-4 flex items-center gap-x-2 justify-center">

                            <a href="edit.php?id=<?php echo $i; ?>"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>

                            </a>
                            <a onclick="return confirm('Are you sure?')" href="?id=<?php echo $i; ?>"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </a>

                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php include 'includes/footer.php'; ?>