<?php include 'includes/header.php'; ?>

<h1 class="pageHeadingBig">You Might Also Like</h1>

<div class="gridViewContainer">

  <?php
    
    // Fetch album details
    $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY rand() LIMIT 10");
    
    while($row = mysqli_fetch_assoc($albumQuery)) {      
      echo "<div class='gridViewItem'>
              <a href='album.php?id=" . $row['id'] . "'>
                <img src='" . $row['artworkPath'] . "'>              
                
                <div class='gridViewInfo'>"
                  .$row['title']. 
                "</div>
              </a>                      
            </div>";
          }
    ?>

</div>
          
<?php include 'includes/footer.php'; ?>