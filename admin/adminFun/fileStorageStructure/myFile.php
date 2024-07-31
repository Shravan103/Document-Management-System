<?php session_start() ?>
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
    }

    #file-tree .jstree-icon {
      width: 24px;
      height: 24px;
    }

    #file-tree .jstree-anchor {
      padding-left: 10px;
    }

    #file-tree .folder-node .jstree-anchor {
      background-color: #ffeec6;
      border-radius: 16px;
      padding: 11px;
      margin: 8px 0;
      margin-top: 0;
      display: inline-block;
      line-height: 0.2rem;
      padding-left: 0px;
      padding-bottom: 15px;
    }

    #file-tree .file-node .jstree-anchor {
      background-color: #bcedff;
      border-radius: 16px;
      padding: 11px;
      margin: 8px 0;
      margin-top: 0;
      display: inline-block;
      line-height: 0.2rem;
      padding-left: 0px;
      padding-bottom: 15px;
    }

    .jstree-default .jstree-checkbox {
      background-position: -164px -9px;
    }

    .jstree-default .jstree-checkbox:hover {
      background-position: -164px -9px;
    }

    .jstree-anchor > .jstree-checkbox {
      position: relative;
      top: -5px;
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
  <?php include '/xampp/htdocs/dms/admin/adminExtra/_Aheader.php'; ?>

  <!--IMPORTED FILE STRUCTURE -->
  <h2 class="card-body container mt-5 mb-2 pt-2 pb-2 pl-5 pr-5 text-center text-secondary">--File Structure--</h2>
  <input class="greyLine form-control text-center w-50" type="text" placeholder="Below is the overall Folder-File structure present on this local machine." aria-label="Disabled input example" disabled>
  <div class="card-body container mt-4 mb-2 pt-2 pb-2 pl-5 pr-5">
    <div id="file-tree" class="fileStyle"></div>
  </div>

  <!--  DELETE, CREATE & UPLOAD BUTTONS-->
  <div class="text-center mt-5">
    <button id="delete-btn" class="btn btn-danger">Delete Selected</button>
    <button id="create-folder-btn" class="btn btn-primary">Create Folder</button>
    <button id="upload-file-btn" class="btn btn-success">Upload File</button>
  </div>

  <!-- FOOTER IMPORTED -->
  <div style="margin-top: 110px;">
    <?php
      require '/xampp/htdocs/dms/partials/_footer.php';
    ?>
  </div>
  

  <!-- MODAL FOR CREATE FOLDER -->
  <div class="modal fade" id="createFolderModal" tabindex="-1" role="dialog" aria-labelledby="createFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createFolderModalLabel">Create New Folder</h5>
        </div>
        <div class="modal-body">
          <input type="text" id="new-folder-name" class="form-control" placeholder="Folder Name">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="create-folder-confirm-btn">Create</button>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL FOR UPLOAD FILE -->
  <div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadFileModalLabel">Upload New File</h5>
        </div>
        <div class="modal-body">
          <form id="upload-file-form" action="file_operations.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="operation" value="upload_file">
            <div class="form-group">
              <label for="file-title">Title</label>
              <input type="text" id="file-title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="file-description">Description</label>
              <textarea id="file-description" name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
              <label for="upload-file-input">Choose File</label>
              <input type="file" id="upload-file-input" name="file" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="file-type">File Type</label>
              <input type="text" id="file-type" name="file_type" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="uploaded-by">Uploaded By</label>
              <input type="text" id="uploaded-by" name="uploaded_by" class="form-control" value="<?php echo $_SESSION['srno']; ?>" readonly>
            </div>
            <div class="form-group">
              <label for="file-status">Status</label>
              <select id="file-status" name="status" class="form-control" required>
                <option value="Active">Active</option>
                <option value="Archived">Archived</option>
              </select>
            </div>
            <input type="hidden" id="parent-path" name="path">
            <button type="submit" class="btn btn-primary mt-3">Upload</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      const rootPath = '/xampp/htdocs/dms/filesTemp';

      $('#file-tree').jstree({
        'core': {
          'data': {
            'url': 'get_tree_data.php',
            'dataType': 'json'
          },
          'check_callback': true 
        },
        'plugins': ['checkbox']
      });

      //DELETE FOLDER FUNCTIONALITY
      $('#delete-btn').on('click', function() {
        var selectedNodes = $('#file-tree').jstree("get_selected", true);
        var paths = selectedNodes.map(function(node) {
          return node.id;
        });

        if (paths.length === 0) {
          alert('Please select a file or folder to delete.');
          return;
        }
        
        console.log(paths);
        console.log(paths[0]);

        if (confirm('Are you sure you want to delete the selected files/folders?')) {
          $.ajax({
            url: 'file_operations.php',
            type: 'POST',
            data: {
              operation: 'delete',
              path: paths[0]
            },
            success: function(response) {
              var res = JSON.parse(response);
              if (res.status === 'success') {
                alert('Deleted successfully.');
                $('#file-tree').jstree(true).refresh();
              } else {
                alert('Error in deletion.');
              }
            },
            error: function() {
              alert('Error in deletion.');
            }
          });
        }
      });

      //CREATE FOLDER FUNCTIONALITY
      $('#create-folder-btn').on('click', function() {
        $('#createFolderModal').modal('show');
      });

      $('#create-folder-confirm-btn').on('click', function() {
        var selectedNode = $('#file-tree').jstree("get_selected", true)[0];
        var parentPath = selectedNode ? selectedNode.id : rootPath;
        var folderName = $('#new-folder-name').val();

        if (!folderName) {
          alert('Please enter a folder name.');
          return;
        }

        $.ajax({
          url: 'file_operations.php',
          type: 'POST',
          data: {
            operation: 'create_folder',
            path: parentPath,
            folder_name: folderName
          },
          success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
              $('#createFolderModal').modal('hide');
              $('#file-tree').jstree(true).refresh();
            } else {
              alert('Error in creating folder.');
            }
          },
          error: function() {
            alert('Error in creating folder.');
          }
        });
      });

      //UPLOAD FILE FUNCTIONALITY
      $('#upload-file-btn').on('click', function() {
        var selectedNode = $('#file-tree').jstree("get_selected", true)[0];
        var parentPath = selectedNode ? selectedNode.id : rootPath;
        $('#parent-path').val(parentPath);
        $('#uploadFileModal').modal('show');
      });

      $('#upload-file-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this);

        $.ajax({
          url: 'file_operations.php',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
              $('#uploadFileModal').modal('hide');
              $('#file-tree').jstree(true).refresh();
            } else {
              alert('Error in uploading file.');
            }
          },
          error: function() {
            alert('Error in uploading file.');
          }
        });
      });
    });
  </script>
</body>
</html>
