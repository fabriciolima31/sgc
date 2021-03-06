<?php

namespace app\models;

use Yii;


class Relatorio extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'Usuarios';
    }


    public function getHtmlParaRelatorioPdf(){

        $id_usuario_logado = Yii::$app->user->identity->id;
        $usuario_logado = User::find()->where(['id' => $id_usuario_logado ])->one()->nome;
        $disciplina_cursando = AlunoTurma::find()
                        ->select("D.nome as nome_da_disciplina, T.codigo as codigo_da_turma, T.id as id_da_turma, U.nome as nome_do_professor")
                        ->where(['Aluno_Turma.Usuarios_id' => $id_usuario_logado ])
                        ->innerJoin("Turma as T", "T.id = Aluno_Turma.Turma_id")
                        ->innerJoin("Disciplina as D", "D.id = T.Disciplina_id")
                        ->innerJoin("Professor_Turma as PT","PT.Turma_id = T.id")
                        ->innerJoin("Usuarios as U","U.id = PT.Usuarios_id")
                        ->all();


        for ($i=0; $i<count($disciplina_cursando); $i++){

            $array_ids_das_turmas[$i] = $disciplina_cursando[$i]->id_da_turma;

            $sessoes_turma[$array_ids_das_turmas[$i]] = Sessao::find()
            ->select("count(Sessao.Paciente_id) as contagem_pacientes")
            ->innerJoin("Agenda","Agenda.id = Sessao.Agenda_id")
            ->innerJoin("Paciente","Paciente.id = Sessao.Paciente_id")
            ->where(['Turma_id' => $disciplina_cursando[$i]->id_da_turma])
            ->andwhere(["Sessao.status" => "OS"])
            ->andWhere(["Sessao.Usuarios_id" => $id_usuario_logado])
            ->groupBy("Sessao.Paciente_id")
            ->count();
        }



//$disciplina_cursando[$i]->id_da_turma;

//O aluno x atendeu 20 pacientes da disciplina Y cujo professor é o Z

    $html = '<!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8" />
            </head>
            <body>

            <!-- <h4> Aluno: '.$usuario_logado.' </h4><hr> -->';

            for($i=0; $i < count($disciplina_cursando); $i++){
                $html = $html . '
                <h4> Disciplina: '.$disciplina_cursando[$i]->nome_da_disciplina.' </h4>
                <h4> Turma: '.$disciplina_cursando[$i]->codigo_da_turma.' </h4> 
                <h4> Professor(a): '.$disciplina_cursando[$i]->nome_do_professor.' </h4>
                <!--<h4> Turma id: '.$disciplina_cursando[$i]->id_da_turma.' </h4> -->
                <h4> Quantidade de Atendimentos: '.$sessoes_turma[$disciplina_cursando[$i]->id_da_turma].' </h4>
                <hr>';
            }
    $html = $html . '
            </body>
        </html>';

        return $html;
    }




    public function getDisciplinasLecionando($id_usuario_logado){


        $disciplina_cursando = AlunoTurma::find()
                    ->select("D.nome as nome_da_disciplina, T.codigo as codigo_da_turma, T.id as id_da_turma, U.nome as nome_do_professor, T.semestre, T.ano")
                    ->where(['Aluno_Turma.Usuarios_id' => $id_usuario_logado ])
                    ->innerJoin("Turma as T", "T.id = Aluno_Turma.Turma_id")
                    ->innerJoin("Disciplina as D", "D.id = T.Disciplina_id")
                    ->innerJoin("Professor_Turma as PT","PT.Turma_id = T.id")
                    ->innerJoin("Usuarios as U","U.id = PT.Usuarios_id")
                    ->all();

        return $disciplina_cursando;

    }




    public function getNumeroSessoesAtendidasProfessor ($id_turma,$id_usuario_logado){

            $sessao = Sessao::find()
            ->select("count(Sessao.id) as contagem_pacientes")
            ->innerJoin("Agenda","Agenda.id = Sessao.Agenda_id")
            ->innerJoin("Paciente","Paciente.id = Sessao.Paciente_id")
            ->where(['Turma_id' => $id_turma])
            ->andwhere(["Sessao.status" => "OS"])
            ->andWhere(["Sessao.Usuarios_id" => $id_usuario_logado])
            ->groupBy("Sessao.id")
            ->count();

            return $sessao;


    }



























    //funcao utilizada no método: getDadosParaRelatorio

    public function getDisciplinasCursando($id_usuario_logado){


        $disciplina_cursando = AlunoTurma::find()
                    ->select("D.nome as nome_da_disciplina, T.codigo as codigo_da_turma, T.id as id_da_turma, U.nome as nome_do_professor, T.semestre, T.ano")
                    ->where(['Aluno_Turma.Usuarios_id' => $id_usuario_logado ])
                    ->innerJoin("Turma as T", "T.id = Aluno_Turma.Turma_id")
                    ->innerJoin("Disciplina as D", "D.id = T.Disciplina_id")
                    ->innerJoin("Professor_Turma as PT","PT.Turma_id = T.id")
                    ->innerJoin("Usuarios as U","U.id = PT.Usuarios_id")
                    ->all();

        return $disciplina_cursando;

    }

    //funcao utilizada no método: getDadosParaRelatorio

    public function getNumeroSessoesAtendidas ($id_turma,$id_usuario_logado){

            $sessao = Sessao::find()
            ->select("count(Sessao.id) as contagem_pacientes")
            ->innerJoin("Agenda","Agenda.id = Sessao.Agenda_id")
            ->innerJoin("Paciente","Paciente.id = Sessao.Paciente_id")
            ->where(['Turma_id' => $id_turma])
            ->andwhere(["Sessao.status" => "OS"])
            ->andWhere(["Sessao.Usuarios_id" => $id_usuario_logado])
            ->groupBy("Sessao.id")
            ->count();

            return $sessao;


    }










    public function getDadosParaRelatorioAluno($id){
        
        $id_usuario_logado = $id;
        $usuario_logado = User::find()->where(['id' => $id_usuario_logado ])->one()->nome;

        $disciplina_cursando = $this->getDisciplinasCursando($id_usuario_logado);


        for ($i=0; $i<count($disciplina_cursando); $i++){

            $array_ids_das_turmas[$i] = $disciplina_cursando[$i]->id_da_turma;

            $sessoes_turma[$array_ids_das_turmas[$i]] = $this->getNumeroSessoesAtendidas($disciplina_cursando[$i]->id_da_turma, 
                $id_usuario_logado);

        }

       

        $html ="<legend><hr><h2 style='text-align:left'> Informações Estatísticas sobre Atendimentos </h2></legend>";

        $html = $html. "<table class='table'>";
            $html = $html . "<tr>";   

                $html = $html . "<th>";   
                $html = $html . "Cod. Turma";
                $html = $html . "</th>";   

                $html = $html . "<th>";   
                $html = $html . "Período";
                $html = $html . "</th>";   

                $html = $html . "<th>";   
                $html = $html . "Disciplina";
                $html = $html . "</th>";   

                $html = $html . "<th>";   
                $html = $html . "Professor";
                $html = $html . "</th>";   

                $html = $html . "<th>";   
                $html = $html . "N. Atendimentos";
                $html = $html . "</th>";  

            $html = $html . "</tr>";   

            for($i=0; $i < count($disciplina_cursando); $i++){
                $html = $html . "<tr>";   
                $html = $html . '
                <td>'.$disciplina_cursando[$i]->codigo_da_turma.' </td>
                <td>'.$disciplina_cursando[$i]->ano.'/'.$disciplina_cursando[$i]->semestre.' </td>
                <td>'.$disciplina_cursando[$i]->nome_da_disciplina.'</td>
                <td>'.$disciplina_cursando[$i]->nome_do_professor.' </td>
                <td>'.$sessoes_turma[$disciplina_cursando[$i]->id_da_turma].' </td>
                ';
                $html = $html . "</tr>";    
            }
        $html = $html . "</table>";

        return $html;
    }






   public function getDadosParaRelatorioProfessor($id_professor){
        

        $disciplina_cursando = $this->getDisciplinasLecionando($id_professor);

        for ($i=0; $i<count($disciplina_cursando); $i++){

            $array_ids_das_turmas[$i] = $disciplina_cursando[$i]->id_da_turma;

            $sessoes_turma[$array_ids_das_turmas[$i]] = $this->getNumeroSessoesAtendidasProfessor($disciplina_cursando[$i]->id_da_turma, 
                $id_professor);

        }

       

        $html ="<legend><hr><h2 style='text-align:left'> Informações Estatísticas sobre Atendimentos </h2></legend>";

        $html = $html. "<table class='table'>";
            $html = $html . "<tr>";   

                $html = $html . "<th>";   
                $html = $html . "Cod. Turma";
                $html = $html . "</th>";   

                $html = $html . "<th>";   
                $html = $html . "Período";
                $html = $html . "</th>";   

                $html = $html . "<th>";   
                $html = $html . "Disciplina";
                $html = $html . "</th>";   

                $html = $html . "<th>";   
                $html = $html . "Professor";
                $html = $html . "</th>";   

                $html = $html . "<th>";   
                $html = $html . "N. Atendimentos";
                $html = $html . "</th>";  

            $html = $html . "</tr>";   

            for($i=0; $i < count($disciplina_cursando); $i++){
                $html = $html . "<tr>";   
                $html = $html . '
                <td>'.$disciplina_cursando[$i]->codigo_da_turma.' </td>
                <td>'.$disciplina_cursando[$i]->ano.'/'.$disciplina_cursando[$i]->semestre.' </td>
                <td>'.$disciplina_cursando[$i]->nome_da_disciplina.'</td>
                <td>'.$disciplina_cursando[$i]->nome_do_professor.' </td>
                <td>'.$sessoes_turma[$disciplina_cursando[$i]->id_da_turma].' </td>
                ';
                $html = $html . "</tr>";    
            }
        $html = $html . "</table>";

        return $html;
    }




}
