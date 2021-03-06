<?php
class animauxC extends Controller
{
    public function __construct()
    {
        $this->animauxModel = $this->model('animauxM');
    }

    public function addAnimauxC()
    {
        $data = [
            'nomAnimal' => '',
            'type' => '',
            'age' => '',
            'pays' => '',
            'status' => '',
            'regimeAlimentaire' => '',
            'image' => '',
            'errorAdd' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'nomAnimal' => trim($_POST['nomAnimal']),
                'type' => trim($_POST['type']),
                'age' => trim($_POST['age']),
                'pays' => trim($_POST['pays']),
                'status' => trim($_POST['status']),
                'regimeAlimentaire' => trim($_POST['regimeAlimentaire']),
                'image' => trim($_POST['image']),
                'errorAdd' => ''
            ];

            //Validate nomAnimal
            if (empty($data['nomAnimal'])) { //check if name is empty or not
                $data['errorAdd'] = 'Please enter name.';
            } elseif (!ctype_alpha($data['nomAnimal'])) { //check name regex
                $data['errorAdd'] = 'Please enter just letters for the name.';
            }

            if (empty($data['type'])) {
                $data['errorAdd'] = 'Please enter the type.';
            }

            if (empty($data['pays'])) {
                $data['errorAdd'] = 'Please enter the country name.';
            } elseif (!ctype_alpha($data['pays'])) {
                $data['errorAdd'] = 'country name can only contain letters.';
            }

            if (empty($data['age'])) {
                $data['errorAdd'] = 'Please enter age.';
            } elseif (!is_numeric($data['age'])) {
                $data['errorAdd'] = 'age can only contain numbers.';
            }
            if (empty($data['status'])) {
                $data['errorAdd'] = 'Please enter the status.';
            }

            if (empty($data['regimeAlimentaire'])) {
                $data['errorAdd'] = 'Please enter the right food.';
            }

            if (empty($data['image'])) {
                $data['errorAdd'] = 'Please enter the right pic.';
            }

            // Make sure that errors are empty
            if (empty($data['errorAdd'])) {

                //add animal from model function
                if (!$this->animauxModel->addanimauxM($data)) {
                    die('Something went wrong.');
                }
            }
        }
        $this->view('animaux', $data);
    }


    public function afficherList($error = '')
    {
        $tab = $this->animauxModel->afficherAnimaux();
        $data = [
            'tab' => '',
            'errorAffiche' => '',
            'idRegime' => '',
            'stable' => '',
            'menace' => '',
            'endanger' => ''
 
        ];
        //stat elements

        $stable = $this->animauxModel->getStable();
        $data['stable'] = $stable[0][0];

        $menace = $this->animauxModel->getMenace();
        $data['menace'] = $menace[0][0];

        $endanger = $this->animauxModel->getEndanger();
        $data['endanger'] = $endanger[0][0];

        //
        if (isset($error)) {
            $errorTab = explode("-", $error);
            if ($errorTab[0] == 'err') {
                array_shift($errorTab);
                $data['errorAdd'] = implode(" ", $errorTab);
            } else if ($errorTab[0] == 'errUp') {
                array_shift($errorTab);
                $data['errorUpdate'] = implode(" ", $errorTab);
            } else {
                $data['errorAdd'] = '';
                $data['errorUpdate'] = '';
            }
        }


        foreach ($tab as $key => $value) {
            $data['tab'] .= '<tr class="tblRows" data=' . $value[0] . "-" . $value[1] . "-" . $value[2] . "-" . $value[3] . "-" . $value[4] . "-" . $value[5] . "-" . $value[6] . "-" . $value[7] . '>
            <td>' . $value[0] . '</td>
            <td data-label="Nom">' . $value[1] . '</td>
            <td>' . $value[2] . '</td>
            <td>' . $value[3] . '</td>
            <td>' . $value[4] . '</td>
            <td>' . $value[5] . '</td>
            <td>' . $value[6] . '</td>
            <td> <img src="../public/img/' . $value[7] . '" width = "75" height = "50"/></td>
            <td> <i class="fas fa-pencil-alt updateButton" onclick="openFormModifier()">
        </tr>';
        }

        $idRegime = $this->animauxModel->listRegimeID();
        foreach ($idRegime as $key => $value) {
            $data['idRegime'] .= '<option value="' . $value[0] . '">' . $value[0] . '</option>';
        }


        $this->view('animaux', $data);
    }

    public function deleteUpdateTabAnimal()
    {
        if (isset($_POST['delete'])) {
            $this->animauxModel->deleteAnimal($_POST['id']);
            header('location:' . URLROOT . '/pages/animaux');
        } elseif (isset($_POST['update'])) {
            $data = [
                'id',
                'nomAnimal' => '',
                'type' => '',
                'age' => '',
                'pays' => '',
                'status' => '',
                'regimeAlimentaire' => '',
                'image' => '',
                'errorUpdate' => ''
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'id' => trim($_POST['id']),
                    'nomAnimal' => trim($_POST['nomAnimal']),
                    'type' => trim($_POST['type']),
                    'age' => trim($_POST['age']),
                    'pays' => trim($_POST['pays']),
                    'status' => trim($_POST['status']),
                    'regimeAlimentaire' => trim($_POST['regimeAlimentaire']),
                    'image' => trim($_POST['image']),
                    'errorUpdate' => ''
                ];

                //Validate nomAnimal
                if (empty($data['nomAnimal'])) { //check if name is empty or not
                    $data['errorAdd'] = 'Please enter name.';
                } elseif (!ctype_alpha($data['nomAnimal'])) { //check name regex
                    $data['errorAdd'] = 'Please enter just letters for the name.';
                }

                if (empty($data['type'])) {
                    $data['errorAdd'] = 'Please enter the type.';
                }

                if (empty($data['pays'])) {
                    $data['errorAdd'] = 'Please enter the country name.';
                } elseif (!ctype_alpha($data['pays'])) {
                    $data['errorAdd'] = 'country name can only contain letters.';
                }

                if (empty($data['age'])) {
                    $data['errorAdd'] = 'Please enter age.';
                } elseif (!is_numeric($data['age'])) {
                    $data['errorAdd'] = 'age can only contain numbers.';
                }
                if (empty($data['status'])) {
                    $data['errorAdd'] = 'Please enter the status.';
                }

                if (empty($data['regimeAlimentaire'])) {
                    $data['errorAdd'] = 'Please enter the food.';
                }

                if (empty($data['image'])) {
                    $data['errorAdd'] = 'Please enter the image.';
                }

                // Make sure that errors are empty
                if (empty($data['errorUpdate'])) {

                    //add employe from model function
                    if (!$this->animauxModel->updateAnimal($data)) {
                        die('Something went wrong.');
                    }
                }
            }
            $this->view('animaux', $data);
        }
    }

    public function trierParID()
    {
        $tab = $this->animauxModel->triID();
        $data = [
            'tab' => ''
        ];
    

        //
        foreach ($tab as $key => $value) {
            $data['tab'] .= '<tr class="tblRows" data=' . $value[0] . "-" . $value[1] . "-" . $value[2] . "-" . $value[3] . "-" . $value[4] . "-" . $value[5] . "-" . $value[6] . "-" . $value[7] . '>
            <td>' . $value[0] . '</td>
            <td data-label="Nom">' . $value[1] . '</td>
            <td>' . $value[2] . '</td>
            <td>' . $value[3] . '</td>
            <td>' . $value[4] . '</td>
            <td>' . $value[5] . '</td>
            <td>' . $value[6] . '</td>
            <td> <img src="../public/img/' . $value[7] . '" width = "75" height = "50"/></td>
            <td> <i class="fas fa-pencil-alt updateButton" onclick="openFormModifier()">
        </tr>';
        }


        $this->view('animaux', $data);
    }

    public function trierParAge()
    {
        $tab = $this->animauxModel->triAge();
        $data = [
            'tab' => ''
 
        ];

        foreach ($tab as $key => $value) {
            $data['tab'] .= '<tr class="tblRows" data=' . $value[0] . "-" . $value[1] . "-" . $value[2] . "-" . $value[3] . "-" . $value[4] . "-" . $value[5] . "-" . $value[6] . "-" . $value[7] . '>
            <td>' . $value[0] . '</td>
            <td data-label="Nom">' . $value[1] . '</td>
            <td>' . $value[2] . '</td>
            <td>' . $value[3] . '</td>
            <td>' . $value[4] . '</td>
            <td>' . $value[5] . '</td>
            <td>' . $value[6] . '</td>
            <td> <img src="../public/img/' . $value[7] . '" width = "75" height = "50"/></td>
            <td> <i class="fas fa-pencil-alt updateButton" onclick="openFormModifier()">
        </tr>';
        }


        $this->view('animaux', $data);
    }

    public function trierParNomAnimal()
    {
        $tab = $this->animauxModel->triNomAnimal();
        $data = [
            'tab' => ''
        ];
        foreach ($tab as $key => $value) {
            $data['tab'] .= '<tr class="tblRows" data=' . $value[0] . "-" . $value[1] . "-" . $value[2] . "-" . $value[3] . "-" . $value[4] . "-" . $value[5] . "-" . $value[6] . "-" . $value[7] . '>
            <td data-label="Nom">' . $value[0] . '</td>
            <td >' . $value[1] . '</td>
            <td>' . $value[2] . '</td>
            <td>' . $value[3] . '</td>
            <td>' . $value[4] . '</td>
            <td>' . $value[5] . '</td>
            <td>' . $value[6] . '</td>
            <td> <img src="../public/img/' . $value[7] . '" width = "75" height = "50"/></td>
            <td> <i class="fas fa-pencil-alt updateButton" onclick="openFormModifier()">
        </tr>';
        }


        $this->view('animaux', $data);
    }
}
