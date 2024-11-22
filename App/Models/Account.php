<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';

    public static $types            = ['Root', 'Helper', 'Account'];
    public static $class            = [1 => ['Normal', 'حساب عادى'] ,                       2 => ['Accounts Receivables', 'ذمم موردين'] ,   3 => ['Accounts payable', 'ذمم عملاء'],                     4 => ['Receivables staff', 'ذمم موظفين'],                                   5 => ['Orders and credits', 'طلبيات واعتمادات'], 6=> ['Other receivables', 'ذمم أخرى'] ];
    public static $fin_reports      = [1 => ['The general budget', 'الميزانية العمومية'],   2 => ['Income statement', 'قائمة الدخل'],       3 => ['Cash flow statement', 'قائمة التدفقات النقدية'],    4 => ['Statement of changes in equity', 'قائمة التغير في حقوق الملكية'],    5 => ['Supplement', 'الملحق']];
    public static $fin_types        = [['debit', 'مدين'], ['credit', 'دائن']];
    public static $rootsTypes       = [['Assets', 'الأصول'], ['Liabilities', 'الخصوم'], ['Expenses', 'المصروفات'], ['Revenues','الايرادات']];
    protected $fillable =
        [
//          Basic Properties
            'a_name',                       //01
            'e_name',                       //02
            'root_type',                    //03 1 => [Assets, الأصول], 2 => [Liabilities, الخصوم], 3 => [Expenses, المصروفات], 4 => [Revenues, الايرادات]
            'type',                         //04 [root, helper, account];
            'fin_type',                     //05 1 => ['debit', 'مدين'], 2 => ['credit', 'دائن']
            'parent',                       //06 Helper or Root or Null
            'fin_report',                   //07 1: The general budget, 2: Income statement, 3: Cash flow statement, 4: changes in equity Statement, 5: Supplement
            'category',                     //08 General, Banks, Cheques, Expenses, Revenues, ETC

            //          Static Properties
            'code',                         //09
            'level',                        //10 [Int]
            'status',                       //11 1: active, 2: hibernated
            'close_type',                   //12
            'company',                      //13
            'created_at',                   //14
            'created_by',                   //21

//          Null Properties
            'temp_account',                 //22
            'Reference',                    //22
            'updated_at',                   //20
            'updated_by',                   //22
        ];

    //          Temp Properties

    public static function accountsTypes () {

    }

}
