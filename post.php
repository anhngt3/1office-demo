<?php

class Post
{
//    function  _
    public function getDataPost()
    {
        $url = 'https://vnexpress.net/the-thao';
        $ch = curl_init();
        $timeout = 5; // thời gian đợi để lấy dữ liệu
        curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $lines_string = curl_exec($ch); // lấy nội dung theo URL
        curl_close($ch);
        $json_data = $this->html_to_obj($lines_string); // hiển thị dữ liệu
        return $json_data;
    }

    private function html_to_obj($html)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML($html);
        return $this->element_to_obj($dom);
    }

    private function element_to_obj($dom)
    {
        $data = [];

        $articles = $dom->getElementsByTagName('article');
        foreach ($articles as $key => $article) {
            if ($article->getAttribute('class') === 'item-news item-news-common') {
                $div_commons = $article->getElementsByTagName('div');
                $h3_commons = $article->getElementsByTagName('h3');
                $p_commons = $article->getElementsByTagName('p');
                foreach ($div_commons as $div_common) {
                    if ($div_common->getAttribute('class') === 'thumb-art') {
                        $picture = $div_common->getElementsByTagName('picture');
                        $a_commons = $div_common->getElementsByTagName('a');
                        $img = $picture[0]->getElementsByTagName('img')[0]->getAttribute('src');
                        $base64 = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
                        if ($img !== $base64) {
                            $data[$key]['title'] = $h3_commons[0]->nodeValue;
                            $data[$key]['link'] = $a_commons[0]->getAttribute('href');
                            $data[$key]['description'] = $p_commons[0]->nodeValue;
                            $data[$key]['image'] = $img;
                        }
                    }
                }
            }
        }
        return json_encode([
            'data' => array_values($data)
        ]);
    }
}

$post = new Post();
$result = $post->getDataPost();
echo $result;
?>