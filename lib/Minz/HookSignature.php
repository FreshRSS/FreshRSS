<?php
declare(strict_types=1);

enum Minz_HookSignature {
	case AccumulateString;
	case NoneToNone;
	case NoneToString;
	case OneToOne;
	case PassArguments;
}
