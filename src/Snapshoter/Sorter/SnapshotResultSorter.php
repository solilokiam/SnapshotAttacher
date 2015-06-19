<?php
namespace Snapshoter\Sorter;

class SnapshotResultSorter
{
    public static function sort($snapShotResultList, $direction = null)
    {
        usort(
            $snapShotResultList,
            function ($a, $b) use ($direction) {
                $dateA = new \DateTime($a['StartTime']);
                $dateB = new \DateTime($b['StartTime']);

                if ($dateA == $dateB) {
                    return 0;
                }

                switch ($direction) {
                    case SortDirection::DESC:
                        return ($dateA < $dateB) ? -1 : 1;
                    case SortDirection::ASC:
                    default:
                        return ($dateA < $dateB) ? -1 : 1;
                }
            }
        );

        return $snapShotResultList;
    }
}