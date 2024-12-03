<?php

namespace Database\Seeders;

use App\Models\Insurance;
use App\Models\InsuranceBenefit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsuranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================================================
        // ============================= Insurance Section ============================
        // ============================================================================
        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/1- Medgulf.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 1,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);

        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/2- Rajhe.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 2,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 2,
            'benefit_title' => 'تغطية الحوادث الشخصية للسائق والركاب',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 2,
            'benefit_title' => 'المساعدة على الطريق',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 2,
            'benefit_title' => 'تغطية ضد كسر الزجاج والحرائق والسرقة',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 2,
            'benefit_title' => 'تغطية الكوارث الطبيعية',
        ]);

        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/3- Alsagr.svg',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 3,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);

        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/4- Arabia Insurance.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 4,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 4,
            'benefit_title' => 'تغطية الحوادث الشخصية للسائق فقط',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 4,
            'benefit_title' => 'تغطية الحوادث الشخصية للركاب فقط',
        ]);
        
        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/5- Liva.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 5,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);

        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/6- ACIG.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 6,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 6,
            'benefit_title' => 'تغطية الحوادث الشخصية للسائق فقط',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 6,
            'benefit_title' => 'تغطية الحوادث الشخصية للركاب والركاب',
        ]);

        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/7- Etihad.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 7,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 7,
            'benefit_title' => 'تغطية الحوادث الشخصية للسائق فقط',
        ]);

        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/8- ggi.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 8,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 8,
            'benefit_title' => 'تغطية الحوادث الشخصية للسائق فقط',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 8,
            'benefit_title' => 'تغطية الحوادث الشخصية للسائق والركاب',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 8,
            'benefit_title' => 'المساعدة على الطريق',
        ]);
        
        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/9- Gulf Union.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 9,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);

        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/10- Walaa.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 10,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);
        
        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/11- Buruj.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 11,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);
        
        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/12- malath.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 12,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 12,
            'benefit_title' => 'تغطية الحوادث الشخصية للسائق فقط',
        ]);
        
        Insurance::create([
            'insurance_type' => 1, // 1 => ضد الغير
            'image' => 'storage/images/insurances/13- Salama.png',
            'price' => rand(300, 1500),
            'status' => 1, // 1 => Active
        ]);
        InsuranceBenefit::create([
            'insurance_id' => 13,
            'benefit_title' => 'المسؤولية المدنية تجاه الغير بحد أقصى 10,000,000 ريال',
        ]);
    }
}
