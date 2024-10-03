<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>

    <link rel='icon' type='image/png' href='/public/images/abc_icon.png'/>

    <title><?php echo $content['title']; ?></title>

    <link rel='stylesheet' href='/public/css/style.css'>

    <script src='https://cdn.tailwindcss.com'></script>
    <script src='https://kit.fontawesome.com/e29189de31.js' crossorigin='anonymous'></script>
</head>

<body class='bg-cover bg-center'>

<div class='flex flex-row flex-nowrap min-h-screen overflow-hidden bg-gray-200'>
    <div class='flex flex-col flex-1 h-screen relative'>

        <main class='flex-1 overflow-auto'>
            <div class="relative flex flex-col items-center">

                <div class="flex h-20 w-full flex-row items-center justify-between bg-gradient-to-r from-gray-800 via-gray-600 to-gray-400 px-3 text-white">
                    <div class="inline-flex items-center space-x-4">
                        <i class="fas fa-exclamation-circle cursor-pointer fill-current text-5xl"></i>
                        <div class="hover:text-gray-400 cursor-default justify-center"><?php echo $content['header']; ?></div>
                    </div>
                    <div class="transition hover:scale-110"></div>
                </div>

                <div class="w-full flex flex-col items-center">
                    <div class="items-center justify-center">
                        <span><i class="fa-solid fa-triangle-exclamation text-8xl h-32 w-32 ml-3 cursor-pointer transition hover:scale-110 mt-9"></i></span>
                        <div class="w-full text-gray-700 text-3xl mb-7"></div>
                    </div>
                    <div class="w-full bg-red-600 text-center text-white text-2xl py-4">
                        <?php echo $content['message']; ?>
                    </div>
                </div>

                <div class="w-full text-center text-gray-500 my-2"><?php echo $content['info'] ?></div>

                <a href='/home/index' class='flex flex-col flex-grow items-center justify-center rounded mt-3 px-8 mx-auto text-gray-600 h-full'>
                    Go Back
                </a>
            </div>
        </main>
    </div>
</div>

</body>
</html>