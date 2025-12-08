<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PLV - SHIELD Team Leader (History)</title>
  <link rel="stylesheet" href="{{ asset('css/member/member-announcement.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/member/member-profile.css') }}" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Reuse styles from teamleader page */
{{ trim(preg_replace('/\s+/', ' ', file_get_contents('resources/views/member/member-teamleader.blade.php')) ) }}
  </style>
</head>
<body>
  {{-- This view is identical to member-teamleader but with action buttons removed for history/read-only mode --}}
  @include('member.member-teamleader')
</body>
</html>
