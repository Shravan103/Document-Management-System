<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>File Folder Structure</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />
  <style>
    .fileStyle {
      margin: 20px;
      margin-left: 43%;
      margin-bottom: 0;
    }

    #file-tree {
      font-size: 1.4rem;
      /* Increase font size */
    }

    #file-tree .jstree-icon {
      width: 24px;
      /* Increase icon size */
      height: 24px;
    }

    #file-tree .jstree-anchor {
      padding-left: 10px;
      /* Increase space between icon and text */
    }

    /* Background color for folders */
    #file-tree .folder-node .jstree-anchor {
      background-color: #ffeec6;
      /* Light blue for folders */
      border-radius: 16px;
      /* Rounded corners */

      padding: 11px;
      /* Add padding */
      margin: 8px 0;
      /* Add margin */
      margin-top: 0;
      display: inline-block;
      /* Align items to center */
      line-height: 0.2rem;
      /* Center text vertically */
      padding-left: 0px;
      padding-bottom: 15px;
    }

    /* Background color for files */
    #file-tree .file-node .jstree-anchor {
      background-color: #bcedff;
      /* Light gray for files */
      border-radius: 16px;
      /* Rounded corners */

      padding: 11px;
      /* Add padding */
      margin: 8px 0;
      /* Add margin */
      margin-top: 0;
      display: inline-block;
      /* Align items to center */
      line-height: 0.2rem;
      /* Center text vertically */
      padding-left: 0px;
      padding-bottom: 15px;
    }

    input::placeholder {
      font-style: italic;
    }

    .greyLine {
      margin-left: 25%;
    }
  </style>
</head>

<body>
  <!--NAVBAR-->
  <?php include 'C:/xampp/htdocs/dms/admin/adminExtra/_Aheader.php'; ?>

  <!--IMPORTED FILE STRUCTURE -->
  <h2 class="card-body container mt-5 mb-2 pt-2 pb-2 pl-5 pr-5 text-center text-secondary">--File Structure--</h2>
  <input class="greyLine form-control text-center w-50" type="text" placeholder="Below is the overall Folder-File view-only structure present on this local machine." aria-label="Disabled input example" disabled>
  <div class="card-body container mt-4 mb-2 pt-2 pb-2 pl-5 pr-5">
    <div id="file-tree" class="fileStyle"></div>
  </div>

  

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      $('#file-tree').jstree({
        'core': {
          'data': {
            'url': 'get_tree_data.php',
            'dataType': 'json'
          }
        }
      });
    });
  </script>

  <!--IMPORTED FOOTER -->
  <?php
  //require 'C:/xampp/htdocs/dms/partials/_footer.php';
  ?>
  
</body>

</html>