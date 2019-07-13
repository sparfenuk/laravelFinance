<!DOCTYPE html>
/*
| this is basic layout what every view gonna extend
| this contains navigation bar and user profile link + header and footer
*/

<html>
<head>

</head>
<body>
<p>Header</p>
    /*
    |   here is gonna be shown content from page what gonna extend this page
    |   to do that use  @extend('layout')
    |   and use this section to display content you need
    |
    |   here should be content of your page

    */
@yield('content')
<p>Footer</p>
</body>
</html>
