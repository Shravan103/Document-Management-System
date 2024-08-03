<tbody class="table-group-divider">
    <?php
    if ($result->rowCount() > 0) {
        $no = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $sql1 = "SELECT title, description, file_path, upload_date, uploaded_by FROM documents WHERE document_id= $row[document_id]";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch(PDO::FETCH_ASSOC);
            $no++;
            echo "<tr>
            <th scope='row'>$no</th>
            <td>{$row1['title']}</td>
            <td>{$row1['description']}</td>
            <td>{$row1['upload_date']}</td>
            <td>";
            $sql2 = "SELECT status FROM document_approvals WHERE document_id= $row[document_id]";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch(PDO::FETCH_ASSOC);
            echo $row2['status'];
            echo "</td>
            <td>
                <form action='toggle_star.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='document_id' value='{$row['document_id']}'>
                    <button type='submit'>";
            $starred_sql_check = "SELECT * FROM starred_documents WHERE user_id=$user AND document_id={$row['document_id']}";
            $starred_check_result = $conn->query($starred_sql_check);
            echo $starred_check_result->rowCount() > 0 ? 'Unstar' : 'Star';
            echo "</button>
                </form>
            </td>
            <td>
                <form action='view_file.php' method='GET' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row1['file_path']}'>
                    <button type='submit'>View</button>
                </form>
            </td>";
            
            // Check access_type for displaying download button
            if ($row['access_type'] == 'View and Download') {
                echo "<td>
                    <form action='download_file.php' method='GET' style='display:inline;'>
                        <input type='hidden' name='new' value='{$row1['file_path']}'>
                        <button type='submit'>Download</button>
                    </form>
                </td>";
            } else {
                echo "<td></td>";
            }

            echo "</tr>";
        }
    }
    ?>
</tbody>
