<?php

use yii\db\Migration;

/**
 * Class m220106_044211_load_areas
 */
class m220106_044211_load_areas_orientations extends Migration
{
    const AREAS_ORIENTATIONS =[
        'Administración y políticas públicas' => [ // dpto Administración publica
            'Gestion pública',
            'Gestión de recursos humanos',
            'Políticas públicas',
            'Metodología de la administración pública',
            'Teoría de la administración',
        ],
        'Economía, finanzas y contabilidad' => [
            'Economía',
            'Finanzas y contabilidad',
        ],
        'Jurídica' => [
            'Derecho público',
            'Derecho privado',
        ],
        'Ciencias básicas y tecnológicas' => [ // dpto gestion agropecuaria
            'Química general y aplicada',
        ],
        'Gestión de recursos naturales' => [
            'Botánica y ecofisiología',
            'Suelos e hidrología',
        ],
        'Gestión de recursos productivos' => [
            'Producción vegetal',
            'Producción animal',
            'Sistemas agrarios',
            'Integración productiva',
        ],
        'Gestión de la empresa agropecuaria' => [
            'Gestión agropecuaria',
            'Comercialización',
        ],
        'Comunicación y cultura' => [ // depto lengua lit. y com.
            'Comunicación, educación y cultura',
        ],
        'Lingüística y discurso' => [
            'Morfología y sintaxis',
            'Estudios textuales',
            'Lingüística teórica',
        ],
        'Cultura y literatura' => [
            'Literatura española',
            'Literatura latinoamericana',
            'Literatura argentina',
            'Metodología y teoría literaria',
        ],
        'Formación específica' => [
            'Formación propedéutica',
            'Formación para la práctica profesional',
        ],
        'Exactas' => [ // dpto de ciencia y tec.
            'Matemática',
            'Estadística',
        ],
        'Tecnología de la inforrmación y la comunicación' => [
            'Tecnología de la inforrmación y la comunicación',
        ],
        'Psicológica' => [ // dpto de psicopedagogia
            'Fundamentos psicológicos del aprendizaje',
            'Psicología general y del desarrollo',
            'Fundamentos de la constitución del sujeto',
        ],
        'Psicopedagógica' => [
            'Clínica psicopedagógica',
            'Operativo-Laboral',
            'Institucional',
        ],
        'Pedagógica-Didáctica-Política' => [
            'Pedagógica',
            'Didáctica',
            'Política-Pedagógica',
        ],
        'Teoría y metodología de la investigación' => [
            'Filosófica',
            'Epistemología de las ciencias sociales y humanas',
            'Metodología de las ciencias sociales y humanas',
        ],
        'Política' => [ //dpto de estudios politicos
            'Teoría política clásica y moderna',
            'Teoría política contemporánea',
        ],
        'Teoría y práctica de la investigación política' => [
            'Integración y aplicación de contenidos',
            'Métodos y técnicas de investigación política',
        ],
        'Socio antropológica' => [
            'Sociológica',
            'Antropológica',
        ],
        'Histórica' => [
            'Histórica',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading areas and orientations...\n";
        foreach(self::AREAS_ORIENTATIONS as $area => $orientations) {
            $orientationIds = [];
            foreach($orientations as $orientation) {
                $this->insert('orientations', [
                    'name' => $orientation,
                    'code' => \Yii::$app->slug->format($orientation, '-'),
                ]);
                $orientationIds[] = \Yii::$app->db->getLastInsertID();

            }
            $this->insert('areas', [
                'name' => $area,
                'code' => \Yii::$app->slug->format($area, '-'),
            ]);
            $areaId = \Yii::$app->db->getLastInsertID();

            foreach($orientationIds as $orientationID) {

                $this->insert('area_orientations', [
                    'area_id' => $areaId,
                    'orientation_id' => $orientationID,
                ]);
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from remuneration types.\n";
        $this->executeFunction(function($table, $remunerationType) {
            $this->delete($table, [
                'code' => \Yii::$app->slug->format($remunerationType),
            ]);
        });
        return true;
    }

    private function executeFunction(callable $callback) : void
    {
        foreach (self::REMUNERATION_TYPES as $remType) {
            $callback('remuneration_types', $remType);
        }

    }
}
