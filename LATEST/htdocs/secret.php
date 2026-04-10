<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hidden Archive</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="secret-page">

  <h1 class="secret-title">Hidden Archive</h1>
  <p class="secret-sub">You found something not meant for everyone...</p>

<div class="creators">

  <div class="card">
    <div class="card-inner">

      <div class="card-front">
        <h2>LORD DRAKE BAZA</h2>
      </div>

      <div class="card-back">
        <p class="role">Programmer / Game Designer</p>
        <p class="desc">Programming the system, designing the game mechanics, and ensuring all components function properly.</p>
        <div class="info">
          <span>Age: 23</span>
          <span>Gender: Male</span>
        </div>
      </div>

    </div>
  </div>

  <div class="card">
    <div class="card-inner">

      <div class="card-front">
        <h2>SHEANE LYKA DALMA</h2>
      </div>

      <div class="card-back">
        <p class="role">Project Manager / Designer</p>
        <p class="desc">Manages the project and ensures development stays organized and aligned with the design vision.</p>
        <div class="info">
          <span>Age: 21</span>
          <span>Gender: Female</span>
        </div>
      </div>

    </div>
  </div>

  <div class="card">
    <div class="card-inner">

      <div class="card-front">
        <h2>CHRISJOHN PAUL DIMAANO</h2>
      </div>

      <div class="card-back">
        <p class="role">Documentation / Web Developer</p>
        <p class="desc">Handles documentation and supports website development and technical reporting.</p>
        <div class="info">
          <span>Age: 21</span>
          <span>Gender: Male</span>
        </div>
      </div>

    </div>
  </div>

  <div class="card">
    <div class="card-inner">

      <div class="card-front">
        <h2>LIANA DENIELLA KUINASALA</h2>
      </div>

      <div class="card-back">
        <p class="role">UI/UX Designer</p>
        <p class="desc">Designs visuals, UI components, and ensures a smooth user experience.</p>
        <div class="info">
          <span>Age: 21</span>
          <span>Gender: Female</span>
        </div>
      </div>

    </div>
  </div>

  <div class="card">
    <div class="card-inner">

      <div class="card-front">
        <h2>MARK JOEL PALMARES</h2>
      </div>

      <div class="card-back">
        <p class="role">QA Tester / UI Support</p>
        <p class="desc">Tests gameplay for bugs and helps improve UI consistency and user experience.</p>
        <div class="info">
          <span>Age: 21</span>
          <span>Gender: Male</span>
        </div>
      </div>

    </div>
  </div>

</div>

  <a href="index.php" class="back-btn">Return</a>
<script>
	document.querySelectorAll(".card").forEach(card => {
  		card.addEventListener("click", () => {
    		card.classList.toggle("flipped");
 		 });
	});
</script>

</body>
</html>