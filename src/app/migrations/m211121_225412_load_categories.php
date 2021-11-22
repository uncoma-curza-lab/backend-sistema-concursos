<?php

use yii\db\Migration;

/**
 * Class m211121_225412_load_categories
 */
class m211121_225412_load_categories extends Migration
{
    const CATEGORIES = [
        [
            'name' => 'Ayudante de primera',
            'code' => 'AYP',
        ],
        [
            'name' => 'Ayudante de segunda',
            'code' => 'AYS',
        ],
        [
            'name' => 'Graduado en formación docente',
            'code' => 'GFD',
        ],
        [
            'name' => 'Jefe de trabajos prácticos',
            'code' => 'JTP',
        ],
        [
            'name' => 'Profesor adjunto',
            'code' => 'PAD',
        ],
        [
            'name' => 'Profesor asociado',
            'code' => 'PAS',
        ],
        [
            'name' => 'Profesor titular',
            'code' => 'PTR',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading categories...\n";

        $this->executeFunction(function($table, $category) {
            $this->insert($table, $category);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start truncate categories.\n";
        $this->executeFunction(function($table, $category) {
            $this->delete($table, [
                'code' => $category['code'],
            ]);

        });
        return true;
    }

    private function executeFunction(callable $callback) : void
    {
        foreach (self::CATEGORIES as $category) {
            $callback('categories', $category);
        }

    }

}
