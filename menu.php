<nav id="main-mav" class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Hírek Portál</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link" href="/">Hírek</a>
        </li>
        
        <?php
        if (!array_key_exists("logged", $_SESSION)) : ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php">login</a>
          </li>
        <?php endif ?>
        <?php if (array_key_exists("user", $_SESSION)) :

        ?>
          <li class="nav-item">
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <?php echo $_SESSION["user"]->firstName; ?>
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="user-profile.php">Profil</a></li>
                <li><a href="list_news.php">Lista</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </div>
          <?php endif ?>
          </li>
      </ul>
    </div>
  </div>
</nav>