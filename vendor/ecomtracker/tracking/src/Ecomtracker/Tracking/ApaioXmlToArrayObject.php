<?php
/*
 * Copyright 2013 Jan Eichhorn <exeu65@googlemail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Ecomtracker\Tracking;
/**
 * A responsetransformer transforming a xml to a simpleXML Object.
 *
 * @author Nikolai Panasenko <nikolai@panasenko.de>
 */
class ApaioXmlToArrayObject implements \ApaiIO\ResponseTransformer\ResponseTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($response)
    {


        $simpleXML = simplexml_load_string($response);

        // quick trick to converth xml to array
        $json = json_encode($simpleXML);

        $array = json_decode($json,TRUE);

        return $array;
    }
}


