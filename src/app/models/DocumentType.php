<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documents_types".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 * @property string|null $category
 *
 * @property ContestAttachedFile[] $contestAttachedFiles
 */
class DocumentType extends \yii\db\ActiveRecord
{
    // Documents Types Codes:
    const NOTE = 'note';
    const INSCRIBED_POSTULATIONS = 'inscribed-postulations';
    const VEREDICT = 'veredict';
    const APPROVAL_RESOLUTION_CONTEST_EVALUATION_COMMISSION = 'approval-resolution-contest-evaluation-commission';
    const APPROVAL_RESOLUTION_CONTEST = 'approval-resolution-contest';
    const APPROVAL_RESOLUTION_TEACHING_JURY = 'approval-resolution-teaching-jury';
    const APPROVAL_RESOLUTION_STUDENT_JURY = 'approval-resolution-student-jury';
    const AD_REFERENDUM_RESOLUTION = 'ad-referendum-resolution';
    const DRAW_RECORD = 'draw-record';
    const DNI = 'dni';
    const CVAR = 'cvar';
    const CV = 'cv';
    const OTHER_PERSONAL = 'other-personal';
    const CERTIFICATES = 'certificates';
    const ACADEMIC_PERFORMANCE = 'academic-performance';
    const UNIVERSITY_DEGREE = 'university-degree';
    const COLLEGE_DEGREE = 'college-degree';
    const NOTE_POSTULATION = 'note-postulation';
    const PRACTICAL_WORK_PROPOSAL = 'practical-work-proposal';
    const PROGRAM_PROPOSAL = 'program-proposal';
    const REGULAR_INSCRIPTION = 'regular-inscription';
    const OTHER_POSTULATION = 'other-postulation';

    // Documents Types Categories:
    const CONTEST_FILE_CATEGORY = 'contest-file';
    const PERSONAL_FILE_CATEGORY = 'personal-file';
    const POSTULATION_FILE_CATEGORY = 'postulation-file';

    const UNIQUE_TYPES = [
        self::DNI,
        self::CVAR,
        self::CV,
        self::PRACTICAL_WORK_PROPOSAL,
        self::PROGRAM_PROPOSAL,
        self::REGULAR_INSCRIPTION
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'category'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'category' => 'Category',
        ];
    }

    /**
     * Gets query for [[ContestAttachedFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContestAttachedFiles()
    {
        return $this->hasMany(ContestAttachedFile::class, ['document_type_id' => 'id']);
    }

    public function getPersonalFiles()
    {
        return $this->hasMany(PersonalFile::class, ['document_type_code' => 'code']);
    }

    /**
     * {@inheritdoc}
     * @return DocumentsTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocumentsTypeQuery(get_called_class());
    }

    public static function getByCode(string $code) : ?self
    {
        return self::find()->getByCode($code);
    }

}
