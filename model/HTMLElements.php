<?php

class HTMLElements {

    public static function table($array, $tableClass = "") {

        if(is_object($array)) {
            $array = (array) $array;
        }

        if(isset($array[0]) && is_object($array[0])) {
            foreach ($array as $key => $value) {
                $array[$key] = (array) $value;
            }
        }

        if(static::is_assoc($array)) {
            $array = [$array];
        }

        if(!is_array($array)) {
            throw new Exception("variable is not an array/object");
        }

        $output = "";
        $output .= "<table class='$tableClass'>";
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

        if(is_object($array)) {
            $array = (array) $array;
        }

        if(isset($array[0]) && is_object($array[0])) {
            foreach ($array as $key => $value) {
                $array[$key] = (array) $value;
            }
        }

        if(static::is_assoc($array)) {
            $array = [$array];
        }

        if(!is_array($array)) {
            throw new Exception("variable is not an array/object");
        }

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
              foreach ($array as $k => $v) {
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

}
