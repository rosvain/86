<!DOCTYPE html>
<html>
    <head>
        <title>86 Bus Route</title>
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <nav class="top-nav">
            </nav>
            <div id='error' class="row center-align">
            <p class="card-panel yellow lighten-2">Sorry, we could not get your location</p>
            </div>
            <div id='alert' class="row center-align">
                <p class="card-panel yellow lighten-2">Alert</p>
            </div>
            <h1 class="center-align">86 BUS</h1>
        </header>
        <main>
            <div class="container section">
                <div class="row center-align">
                    <section class="col s12"><button id="direction" name='outbound' class="waves-effect waves-light btn-large teal darken-1"><i class="mdi-maps-directions-bus left"></i>To Sullivan Station</button></section>
<!--                    <section class="col s6"><button id="outbound" class="waves-effect waves-light btn-large teal lighten-2"><i class="mdi-maps-directions-bus left"></i>To Sullivan Station</button></section>-->
                    <div class="progress col s12">
                        <div class="indeterminate"></div>
                    </div>
                    <table class="col s12 hoverable bordered">
                        <thead>
                            <tr>
                                <th data-field="id"><i class="mdi-maps-place left"></i>Bus Stop</th>
                                <th data-field="name"><i class="mdi-action-alarm left"></i>ETA</th>
                                <th data-field="price"><i class="mdi-action-alarm left"></i>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="bus-stop"><i class="mdi-maps-my-location left"></i>Cleveland Circle</td>
                                <td class="eta">23 Min</td>
                                <td class="time">5:30PM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <footer class="page-footer">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">86 App</h5>
                        <p class="grey-text text-lighten-4">Use this app to check when the 86 bus will be arriving at the closest stop near you.</p>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    © 2014 Propono Decor 
                    <a class="grey-text text-lighten-4 right" href="https://about.me/rosvain">About Me</a>
                </div>
            </div>
        </footer>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script src="js/app.js" type="text/javascript"></script>
    </body>
</html>
