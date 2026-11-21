<?php

namespace App\Enums;

use App\Traits\EnumToArrayTrait;

enum YouthPolicyDirection: string
{
    use EnumToArrayTrait;

    case PATRIOTIC = 'patriot';
    case CULTURAL_AND_CREATIVE = 'cult_cre';
    case INTERETHNIC_HARMONY = 'int_harm';
    case PROTECTION_ON_THE_RIGHTS = 'prot_rights';
    case SUPPORT_OF_DIFFICULT_SITUATIONS = 'sup_dif_sit';
    case SUPPORT_OF_INITIATIVES = 'sup_init';
    case PROMOTION_SOCIAL_ACTIVITIES = 'prom_soc_act';
    case ORGANIZATION_OF_RECREATION = 'org_recreate';
    case PHYSICAL = 'phys';
    case PROVISION_OF_SOCIAL_SERVICES = 'prov_soc_serv';
    case ASSISTANCE_IN_HOUSING_PROBLEMS = 'assist_house';
    case SUPPORT_OF_YOUNG_FAMILIES = 'sup_fam';
    case PROMOTING_EDUCATION = 'prom_edu';
    case LEGAL_EDUCATION = 'leg_edu';
    case TRAINING_OF_SPECIALISTS = 'train_spec';
    case PROMOTION_OF_REALIZATION_RIGHTS = 'prom_realize_rights';
    case MENTORING = 'mentoring';
    case PROMOTING_IN_EMPLOYMENT = 'prom_employee';
    case SUPPORT_OF_BUSINESS_ACTIVITIES = 'sup_bs';
    case CREATING_SELF_REALIZATION = 'create_self_real';
    case SUPPORT_FOR_PUBLIC_ASSOCIATIONS = 'sup_pub_assoc';
    case PROMOTING_VOLUNTEER = 'prom_volun';
    case ENVIRONMENTAL = 'env';
    case PROMOTING_INTERNATIONAL_COOPERATION = 'prom_int_coop';
    case PREVENTION_OF_OFFENSES = 'prev_offenses';
    case SUPPORT_OF_CIVIL_IDENTITY = 'sup_civ_id';
    case CONDUCTING_SCIENTIFIC = 'cond_science';

    public function getDisplayName(): string
    {
        return match ($this) {
            self::PATRIOTIC => 'Патриотическое воспитание молодежи',
            self::CULTURAL_AND_CREATIVE => 'Духовно-нравственное воспитание молодежи',
            self::INTERETHNIC_HARMONY => 'Обеспечение межнационального (межэтнического) и межконфессионального согласия в молодежной среде',
            self::PROTECTION_ON_THE_RIGHTS => 'Обеспечение защиты прав и законных интересов молодежи',
            self::SUPPORT_OF_DIFFICULT_SITUATIONS => 'Поддержка молодых граждан, оказавшихся в трудной жизненной ситуации, инвалидов и лиц с ОВЗ',
            self::SUPPORT_OF_INITIATIVES => 'Поддержка инициатив, в том числе инициативных проектов, молодеж',
            self::PROMOTION_SOCIAL_ACTIVITIES => 'Содействие общественной деятельности, направленной на поддержку молодежи',
            self::ORGANIZATION_OF_RECREATION => 'Организация досуга, отдыха, вовлечение в социальный и внутренний туризм в условиях природной среды',
            self::PHYSICAL => 'Формирование условий для занятий физической культурой, спортом',
            self::PROVISION_OF_SOCIAL_SERVICES => 'Предоставление социальных услуг молодежи',
            self::ASSISTANCE_IN_HOUSING_PROBLEMS => 'Содействие решению жилищных проблем молодежи, молодых семей',
            self::SUPPORT_OF_YOUNG_FAMILIES => 'Поддержка молодых семей, сохранение и укрепление традиционных семейных ценностей и семейного образа жизни в молодежной среде',
            self::PROMOTING_EDUCATION => 'Содействие образованию молодежи, научной, научно-технической деятельности молодежи, повышению мотивации у молодых граждан к получению новых знаний, в том числе путем самообразования, поддержка молодых ученых',
            self::LEGAL_EDUCATION => 'Правовое просвещение и правовое информирование молодежи',
            self::TRAINING_OF_SPECIALISTS => 'Организация подготовки специалистов по работе с молодежью',
            self::PROMOTION_OF_REALIZATION_RIGHTS => 'Выявление, сопровождение и поддержка молодежи, проявившей одаренность, содействие реализации прав молодых граждан на свободу литературного, художественного, научного, технического и других видов творчества',
            self::MENTORING => 'Развитие института наставничества',
            self::PROMOTING_IN_EMPLOYMENT => 'Обеспечение гарантий в сфере труда и занятости молодежи, содействие трудоустройству молодых граждан, в том числе посредством студенческих отрядов',
            self::SUPPORT_OF_BUSINESS_ACTIVITIES => 'Поддержка и содействие предпринимательской деятельности молодежи',
            self::CREATING_SELF_REALIZATION => 'Формирование условий для самореализации молодых граждан через их вовлечение в социально-экономическое развитие сельских территорий и повышение привлекательности сельского образа жизни',
            self::SUPPORT_FOR_PUBLIC_ASSOCIATIONS => 'Поддержка деятельности молодежных общественных объединений, некоммерческих организаций',
            self::PROMOTING_VOLUNTEER => 'Содействие участию молодежи в добровольческой (волонтерской) деятельности',
            self::ENVIRONMENTAL => 'Формирование у молодежи экологической культуры и экологически ответственного мировоззрения',
            self::PROMOTING_INTERNATIONAL_COOPERATION => 'Содействие международному и межрегиональному сотрудничеству в сфере молодежной политики',
            self::PREVENTION_OF_OFFENSES => 'Предупреждение правонарушений и антиобщественных действий молодежи',
            self::SUPPORT_OF_CIVIL_IDENTITY => 'Поддержка деятельности по созданию и распространению в средствах массовой информации, произведений, направленных на укрепление гражданской идентичности',
            self::CONDUCTING_SCIENTIFIC => 'Проведение научно-аналитических исследований по вопросам молодежной политики',
        };
    }
}
