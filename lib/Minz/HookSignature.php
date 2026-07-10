<?php
declare(strict_types=1);

namespace FreshRss\Minz;

enum HookSignature {
	case NoneToNone;
	case NoneToString;
	case OneToOne;
	case PassArguments;
}
