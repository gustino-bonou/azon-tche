<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New task assign</title>
    <!-- Inclusion de Bootstrap et Montserrat via CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
                
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            color: #000000; 
            background-color: #ffffff; 
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            height: auto;
            margin: 20px auto;
            background-color: #ffffff; 
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e6e6e6; 
        }
        .header {
            background-color: #00292D;
            padding: 5px;
        }
        .header h3 {
            font-size: 24px;
            margin:25px;
            color: #ffffff;
            text-align: center; 
        }
        .content {
            padding: 30px; 
            color: #000000; 
            margin-left: 20px;             
        }
        .content img {
            display: block;
            margin-top: -15%;
            margin: 0 auto 10px; 
            max-width: 120px; 
        }
        .content h3 {
            font-size: 24px;
            text-align: center;
            padding: 20px;
            font-weight: 600;
            color: #000000; 
        }
        .content p {
            margin: 15px 20px; 
            line-height: 1.6;
            font-size: 16px;
            color: #000000;
        }
        .content .font-weight-bold {
            font-weight: 600;
        }
        .footer {
            background-color: #d3d3d3; /* Gris clair pour le footer */
            text-align: center;
            padding: 20px; 
            font-size: 14px; 
            color: #000000; /* Noir pour le texte du footer */
        }
        .footer p {
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header h3 {
                font-size: 20px; /* Réduction de la taille du titre pour les écrans plus petits */
            }
            .content h3 {
                font-size: 20px; /* Taille de police réduite pour les écrans plus petits */
                margin-top: 16px; /* Espacement supplémentaire au-dessus du titre */
            }
            .content p {
                font-size: 14px; /* Réduction de la taille de la police pour les écrans mobiles */
                margin: 15px 15px; /* Ajustement du décalage des paragraphes */
            }
        }
        @media (max-width: 576px) {
            .content {
                padding: 14px; 
            }
            .header h3 {
                font-size: 16px;
            }
            .content img {
                max-width: 100px; 
                margin-top: -6%;
            }
        }
    </style>
</head>
<body>
    <div class="container email-container">
        <div class="header">
            <h3>AZON-TCHE</h3>
        </div>
        <div class="content">
            <img style="margin-top:10%" src="{{ asset('assets/logo.png') }}" alt="Logo">
            <h3>New task has qssigned to you.</h3> 
            <p>Dear <strong>{{$data['donby_name']}}</strong>,</p>
            <p>A new task has been assigned to you by <strong>{{$data['author_name']}}</strong> </p>
            <p><a href="http://localhost:8081/tasks/{{$data['task_id']}}">Click here to see the details</a></p>
        </div>
    </div>
</body>
</html>
