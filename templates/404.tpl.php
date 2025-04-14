<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>404 - Az oldal nem található</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles/style.css">

    <style>
        #error-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        #error-content {
            align-items: center;
        }
        #error-content h1 {
            font-size: 6rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        #error-content p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }
        #error-content a {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id=error-container>
        <div id=error-content>
            <h1>404</h1>
            <p>A Keresett oldal nem található...</p>
            <a href=".">Vissza a főoldalra</a>
        </div>
    </div>
</body>

</html>
