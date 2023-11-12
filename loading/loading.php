<?php
    if (isset($_POST['status']) && $_POST['status']) {
        $status = $_POST['status'];
        loading_page($status);
    }
    function loading_page($status) {
        if ($status) {
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <style>
                .spinner-wrapper {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.4);
                    z-index: 9999;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                .spinner {
                    display: inline-block;
                    width: 40px;
                    height: 40px;
                    border: 4px solid rgba(0, 0, 0, 0.2);
                    border-top-color: #333;
                    border-radius: 50%;
                    animation: spin 1s ease-in-out infinite;
                    }

                @keyframes spin {
                    to {
                        -webkit-transform: rotate(360deg);
                        transform: rotate(360deg);
                    }
                }
            </style>
        </head>
        <body>
            <div class="spinner-wrapper" id="spinner-wrapper">
                <div class="spinner" id="spinner"></div>
            </div>
        </body>
        </html>
<?php
        }
    }
?>