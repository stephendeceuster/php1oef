<?php
if ($rows->num_rows > 0) {
    // output elke rij
    while ($row = $rows->fetch_assoc()) {
        $output = '<div class="col-sm-4 mb-2">';
        $output .= '<div class="col-sm-12">';
        $output .= '<h3>' . $row["img_title"] . '</h3> ';
        $output .= '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>';
        $output .= '<img src="./img/' . $row["img_filename"] . '" alt="A view from ' . $row["img_title"] . '" title ="A view from ' . $row["img_title"] . '">';
        $output .= '<a href="stad.php?img_id=' . $row["img_id"] . '">Meer info over '. $row["img_title"] . '</a>';
        $output .= '</div></div>';
        echo $output;
    }
} else {
    echo "No records found";
}