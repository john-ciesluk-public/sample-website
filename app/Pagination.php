<?php

namespace App;

class Pagination
{
     /**
    * Makes the pagination html
    *
    * @return string $pagination
    *
    */
    public function makePagination($products,$request,$back)
    {
        $pages = $products->lastPage();
        $pagination = '';
        if (strpos($back,"&page=")) {
            $back = substr($back, 0, strpos($back, "&page="));
        }
        if (strpos($back,"&page=")) {
            $back = substr($back, 0, strpos($back, "?page="));
        }

        if ($pages > 1) {
            $pagination .= '<ul class="pagination">';
            $pagination .= '<li class="disabled"><span>«</span></li>';
            $pagination .= '<li class="active"><span>1</span></li>';
            for ($i=2;$i<=$pages;$i++) {
                if ($request->input('category')) {
                    $page = $back . '&page=' . $i;
                } else {
                    $page = $back . '?page=' . $i;
                }
                $pagination .= '<li><a href="' . $page . '">' . $i . '</a></li>';
            }
            if ($request->input('category')) {
                $page = $back . '&page=2';
            } else {
                $page = $back . '?page=2';
            }

            $pagination .= '<li><a href="' . $page . '"><span>»</span></a></li>';
            $pagination .= '</ul>';
        }
        return $pagination;
    }
}
