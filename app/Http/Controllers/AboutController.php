<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the about page with mission, vision, and rules.
     */
    public function index()
    {
        // Mission statement
        $mission = "The Pasig City Library Consortium is committed to providing equitable access to information, education, and cultural resources for all residents of Pasig City. We strive to foster a love of learning, support academic achievement, and promote intellectual freedom through our collaborative network of libraries. Our mission is to bridge educational gaps, enhance digital literacy, and create inclusive spaces where knowledge thrives and communities grow stronger through shared learning experiences.";

        // Vision statement
        $vision = "To be the premier library consortium in Metro Manila, recognized for excellence in information services, innovative educational programs, and community engagement. We envision a future where every citizen of Pasig City has seamless access to world-class library resources, advanced technology, and lifelong learning opportunities. Through our integrated network, we aim to transform lives, empower minds, and build a knowledge-based society that drives sustainable development and social progress.";

        // Logo description
        $logoDescription = "The Pasig City Library Consortium logo features a stylized library building symbolizing knowledge, learning, and community. The blue color represents trust, wisdom, and stability, reflecting our commitment to reliable information services. The interconnected design elements signify collaboration between our member libraries, while the open book motif emphasizes our dedication to accessible education. The circular arrangement represents unity and the continuous cycle of learning that we foster within our community.";

        // Rules and guidelines - ALL RULES DATA
        $rules = [
            'Library Membership' => [
                'Valid ID required for registration',
                'Free membership for Pasig City residents',
                'Annual renewal required',
                'Guest access available for visitors'
            ],
            'Borrowing Guidelines' => [
                'Maximum 5 books per member',
                '14-day loan period',
                '2 renewal extensions allowed',
                'Late fees apply after due date'
            ],
            'Digital Resources' => [
                '24/7 online access with library card',
                'Download limits per month',
                'Device compatibility requirements',
                'Technical support available'
            ],
            'Facility Usage' => [
                'Quiet zones enforced',
                'Food and drinks restricted',
                'Computer use by reservation',
                'Study rooms available for booking'
            ],
            'Code of Conduct' => [
                'Respectful behavior required',
                'No disruptive activities',
                'Proper care of materials',
                'Compliance with staff instructions'
            ]
        ];

        // Pass all data to view
        return view('about', compact('mission', 'vision', 'logoDescription', 'rules'));
    }
}
