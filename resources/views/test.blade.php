<html>
   <body>
   @csrf
      <h1>Hello, World</h1>
      <?php

        $users = App\Users::all();

        foreach ($users as $user) {
            echo $user->name;
        }
      ?>
   </body>
</html>
