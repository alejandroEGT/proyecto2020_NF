<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- <link href="{{asset('/fontawesome-free-5.12.0-web/css/all.css')}}" > -->
        <script src="https://kit.fontawesome.com/ebfc476978.js"></script>
        <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        
        <div id="app">
        
        </div>
        <script src="/js/html2pdf.js" type="text/javascript"></script>
        <script src="https://printjs-4de6.kxcdn.com/print.min.js" ></script>
        
  
        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>

        <style>
            body {
                background: #3F51B5;
                /* background: #9d50bb;  */
                background: -webkit-linear-gradient(to right, #3F51B5, #3a7bd5); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #3F51B5, #3a7bd5);
            }

            ul.el-carousel__indicators.el-carousel__indicators--horizontal.el-carousel__indicators--outside {
                background: #3F51B5;
                /* background: #9d50bb;  */
                background: -webkit-linear-gradient(to right, #3F51B5, #3a7bd5); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #3F51B5, #3a7bd5);
            }

            .el-carousel__arrow el-carousel__arrow--left{
                background: #3F51B5;
                /* background: #9d50bb;  */
                background: -webkit-linear-gradient(to right, #3F51B5, #3a7bd5); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #3F51B5, #3a7bd5);
            }

            button.el-carousel__arrow.el-carousel__arrow--right {   
                background: #3F51B5;
                /* background: #9d50bb;  */
                background: -webkit-linear-gradient(to right, #3F51B5, #3a7bd5); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #3F51B5, #3a7bd5);
            }

            button.el-carousel__arrow.el-carousel__arrow--left {
                background: #3F51B5;
                /* background: #9d50bb;  */
                background: -webkit-linear-gradient(to right, #3F51B5, #3a7bd5); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #3F51B5, #3a7bd5);
            }

            .div_page {
                background: #3F51B5;
                /* background: #9d50bb;  */
                background: -webkit-linear-gradient(to right, #3F51B5, #3a7bd5); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #3F51B5, #3a7bd5);
            }

            /* section.el-container.kkck {
                background: url(data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxISDw8QDxAVDxAQ…+H8zNlGjGrhkQK1iQEQAJCEABICIAEgIiAJNCAiNGpAREBLEBCIxJRMREANMREAAEADD//2Q==);
                background-size: 100% 100%;
            } */
            .foto {
                /* background: url(https://images3.alphacoders.com/683/thumb-1920-683882.jpg); */
                background-size: 100% 100%;



                  background-image: linear-gradient(
                    to bottom,
                    rgba(55, 56, 58, 0.52),
                    rgba(44, 41, 43, 0.73)
                ),
                url("https://images3.alphacoders.com/683/thumb-1920-683882.jpg");
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }

            header.el-header {
                border: 1px solid white;
            }

            ul.el-menu-demo.el-menu--horizontal.el-menu {
                border: 1px solid white;
            }


            /* estilo para la tabla historia de habitaciones */
            /* th.el-table_1_column_1.is-leaf,
            th.el-table_1_column_2.is-leaf,
            th.el-table_1_column_3.is-leaf,
            th.el-table_1_column_4.is-leaf,
            th.el-table_1_column_5.is-leaf,
            th.el-table_1_column_6.is-leaf,
            th.el-table_1_column_7.is-leaf,
            th.el-table_1_column_8.is-leaf,
            th.el-table_1_column_9.is-leaf
            {
                    color: white;
                    background:#3F51B5;
            } */
        </style>
   
    </body>
    
</html>
