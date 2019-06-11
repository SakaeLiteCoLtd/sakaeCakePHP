<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
/**
 * Questions Model
 */
class QuestionsTable extends Table
{
    /**
     * {@inheritdoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('questions'); // �g�p�����e�[�u����
        $this->setDisplayField('id'); // list�`���Ńf�[�^�擾�����ۂɎg�p�����J����
        $this->setPrimaryKey('id'); // �v���C�}���L�[�ƂȂ�J������
        $this->addBehavior('Timestamp'); // created�y��modified�J�����������ݒ肷��
        $this->hasMany('Answers', [
            'foreignKey' => 'question_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }
    /**
     * �o���f�[�V�������[���̒�`
     *
     * @param \Cake\Validation\Validator $validator �o���f�[�V�����C���X�^���X
     * @return \Cake\Validation\Validator �o���f�[�V�����C���X�^���X
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id', 'ID���s���ł�')
            ->allowEmpty('id', 'create', 'ID���s���ł�');
        $validator
            ->scalar('body', '������e���s���ł�')
            ->requirePresence('body', 'create', '������e���s���ł�')
            ->notEmpty('body', '������e�͕K�����͂��Ă�������')
            ->maxLength('body', 140, '������e��140���ȓ��œ��͂��Ă�������');
        return $validator;
    }
    /**
     * �񓚕t���̎���ꗗ���擾����
     *
     * @return \Cake\ORM\Query �񓚕t���̎���ꗗ�N�G��
     */
    public function findQuestionsWithAnsweredCount()
    {
        $query = $this->find();
        $query
            ->select(['answered_count' => $query->func()->count('Answers.id')])
            ->leftJoinWith('Answers')
            ->group(['Questions.id'])
            ->enableAutoFields(true);
        return $query;
    }
}