<?php

namespace jitsu\sql\ast;

/* A `UNIQUE` table constraint.
 *
 * <unique-constraint> ->
 *   ["CONSTRAINT" <identifier>] "UNIQUE" "(" <identifier>+{","} ")"
 */
class UniqueConstraint extends ColumnGroupTableConstraint {

}

?>