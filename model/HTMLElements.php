<?php
require_once "ArrayHelper.php";

class HTMLElements {

    public static function table($array, string $tableClass = "", $horizontal = true) {
        
        if($horizontal) {
            return static::tableHorizontalRows($array, $tableClass);
        } else {
            return static::tableVerticalRows($array, $tableClass);
        }
        
    }

    public static function tableVerticalRows($array, string $tableClass) {

        $array = ArrayHelper::to2DArray($array);

        $output = "<table class=\"$tableClass\">";

        foreach($array[0] ?? [] as $key => $value) {
            $output .= "
                <tr>
                    <th>$key</th>
                    <td>$value</td>
                </tr>
            ";
        }

        $output .= "</table>";
        return $output;

    }

    public static function tableHorizontalRows($array, string $tableClass) {

        $array = ArrayHelper::to2DArray($array);

        $output = "<table class='$tableClass'>";
        $output .= "<thead>";

        if(isset($array[0])) {
            $output .= "<tr>";
            foreach (array_keys($array[0]) as $key => $value) {
                $output .= "<th>$value</th>";
            }
            $output .= "</tr>";
        }

        $output .= "</thead>";
        $output .= "<tbody>";

        foreach ($array as $key => $value) {
            $output .= "<tr>";
            foreach ($value as $key => $value) {
                $output .= "<td>$value</td>";
            }
            $output .= "</tr>";
        }

        $output .= "</tbody>";
        $output .= "</table>";

        return $output;
    }

    public static function tableSpec($array) {

        $array = ArrayHelper::to2DArray($array);

        $table = "";
        $table .= "<div class='row'>";

      $table .= "<div class='spec-card mt-5'>
            <div class='card mt-5>
        <div class='card-header'>
          <!-- Specificaties : -->
            <h4>  Specificaties :</h4>
        </div>
        <div class='card-body'>


            <table class='table'>";
              foreach ($array[0] ?? [] as $k => $v) {
              $table .= "<tr>
                <th>$k</th>
                <td>$v</td>
              </tr>";
            }
      $table .= "
            </table>

            </div>
          </div>
          </div>";
      $table .= "</div>";

      return $table;
    }

    public static function is_assoc(array $array) {
        // Keys of the array
        $keys = array_keys($array);

        // If the array keys of the keys match the keys, then the array must
        // not be associative (e.g. the keys array looked like {0:0, 1:1...}).
        return array_keys($keys) !== $keys;
    }

    public static function generateForm(array $fields, string $action = "", string $method = "post", string $class = "", string $buttonText) {

        $inputs = "";

        foreach ($fields as $key => $value) {

            if($value["Extra"] != "auto_increment") {

                $type = "text";
                $title = ucfirst(str_replace("_", " ", $value["Field"]));
                $attribs = [];
                $name = $value["Field"];
                $val = ($value["value"] ?? "");

                $pieces = preg_split("/\W+/", $value["Type"]);

                if($value["Null"] === "NO") {
                    $attribs[] = "required";
                }

                switch ($pieces[0]) {
                    case 'int':
                        $type = "number";
                        break;
                    case 'decimal':
                        $type = "number";
                        $attribs[] = "step=\"0.".str_repeat("0", intval($pieces[2]) - 1)."1\"";
                        break;
                    case 'varchar':
                        $type = "text";
                        $attribs[] = "maxLength=\"$pieces[1]\"";
                        break;
                    case 'text':
                        $type = "textarea";
                        break;
                    case 'tinyint':
                        if(intval($pieces[1]) > 1) {
                            $type = "number";
                        } else {
                            $type = "checkbox";
                        }
                        break;
                }

                switch($pieces[2] ?? "") {
                    case "unsigned":
                        $attribs[] = "min=\"0\"";
                        break;
                }

                $attribs[] = "type=\"$type\"";

                if($type == "textarea") {
                    // $form .= "<textarea placeholder=\"$title\" name=\"$value[Field]\"></textarea>";
                    // textarea($value["Field"], $title, ($value["value"] ?? ""), implode(" ", $attribs));
                    $inputs .= "
                    <div class=\"form-group\">
                        <label for=\"$name\">$title</label>
                        <textarea id=\"$name\" class=\"form-control\" placeholder=\"$title\" name=\"$name\">$val</textarea>
                    </div>
                    ";
                } else if($type == "checkbox") {
                    $inputs .= "
                    <div class=\"form-group form-check\">
                        <input id=\"$name\" class=\"form-check-input\" placeholder=\"$title\" name=\"$name\" ".implode(" ", $attribs)." value=\"$val\">
                        <label class=\"form-check-label\" for=\"$name\">$title</label>
                    </div>
                    ";
                } else {
                    // $form .= "<input placeholder=\"$title\" type=\"$type\" name=\"$value[Field]\" ".implode(" ", $attribs)." value=\"\">";
                    // input($value["Field"], $type, $title, ($value["value"] ?? ""), implode(" ", $attribs));
                    $inputs .= "
                    <div class=\"form-group\">
                        <label for=\"$name\">$title</label>
                        <input id=\"$name\" class=\"form-control\" placeholder=\"$title\" name=\"$name\" ".implode(" ", $attribs)." value=\"$val\">
                    </div>
                    ";
                }

            }
        }

        $inputs .= "
        <div class=\"form-group\">
            <input value=\"".ucfirst($buttonText)."\" type=\"submit\" name=\"submit\" class=\"btn btn-primary\">
        </div>
        ";

        $form = "
        <form class=\"form\" action=\"$action\" method=\"$method\">

        $inputs

        </form>";

        return $form;
    }

    /**
     * paginator html stuff
     *
     * @param integer $pages the amount of pages there are
     * @param integer $current_page the page your currently on
     * @param string $url the url you want to use for pages e.g. "/product/overview/{page}" or "?page={page}" or something, it replaces {page} with the page number
     * @return string $pagination the paginator
     */
    public static function pagination(int $pages, int $current_page, string $url) {

        if($pages <= 1)
            return "";

        $output = "
        <nav aria-label=\"Page navigation\">
            <ul class=\"pagination\">
        ";

        $output .= "<li class=\"page-item ". (($current_page == 0) ? 'disabled' : '') ."\"><a class=\"page-link\" href=\"". str_replace("{page}", ($current_page - 1), $url) ."\"><i class=\"fas fa-caret-left\"></i></a></li>";
        
        for($i = 0; $i < $pages; $i++) {
            $output .= "<li class='page-item " . (($current_page ?? 0) == $i ? 'active' : '') . "'><a class='page-link' href='". str_replace("{page}", $i, $url) ."'>". ($i + 1) ."</a></li>";
        }

        $output .= "<li class=\"page-item ". ((($current_page + 1) == $pages) ? 'disabled' : '') ."\"><a class=\"page-link\" href=\"". str_replace("{page}", ($current_page + 1), $url) ."\"><i class=\"fas fa-caret-right\"></i></a></li>";

        $output .= "
            </ul>
        </nav>
        ";

        return $output;
    }

}
