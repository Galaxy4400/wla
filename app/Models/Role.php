<?php

namespace App\Models;

use App\Traits\HasMultyRelation;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
	use HasMultyRelation;
}
