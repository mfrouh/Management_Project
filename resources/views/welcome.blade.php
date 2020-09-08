<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

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
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div id="app1">
                  <app-header/>
                </div>
                <div id="app">
                    @{{ message | reverse }}
                    @{{ name  }}
                    <div  :style="{'background':color}" style="height: 100px;width:100px;border-radius:38px" ></div>
                    <a @click="color='blue'">blue</a>
                    <a @click="color='yellow'">yellow</a>
                    <a @click="color='red'">red</a>
                    <a @click="color='green'">green</a>
                 <input type="text" v-model="name">
                 <button @click="addtask">add task</button>
                 <ul v-for="(task, index) in tasks" :key="index">
                     <li @click="deletetask(index)" >@{{ task }}</li>
                 </ul>
                  </div>
                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
    <script src="{{asset('vue.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script>
      var app = new Vue({
         el: '#app',
         data: {
           message: 'Hello Vue!',
           color:'red',
           name:'',
           tasks:[]
         },
         methods: {
             addtask()
             {
                if(this.name){
                this.tasks.push(this.name);
                this.name='';
                }
             },
             deletetask(index)
             {

                this.tasks.splice(index,1);
             },
         },
         filters:
         {
           reverse(index)
           {
             return  index.split("").reverse().join("").substring(0,7);
           }
         }
       })
    </script>
</html>
