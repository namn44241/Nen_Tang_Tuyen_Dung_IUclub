import { Icon, Sidebar, Card, Heading } from "../../components";
import { __ } from '@wordpress/i18n';

const Homepage = () => {
    const cardLists = [
        {
            iconSvg: <Icon icon="site" />,
            heading: __('Site Identity', 'jobscout'),
            buttonText: __('Customize', 'jobscout'),
            buttonUrl: cw_dashboard.custom_logo
        },
        {
            iconSvg: <Icon icon="colorsetting" />,
            heading: __("Color Settings", 'jobscout'),
            buttonText: __('Customize', 'jobscout'),
            buttonUrl: cw_dashboard.colors
        },
        {
            iconSvg: <Icon icon="layoutsetting" />,
            heading: __("Layout Settings", 'jobscout'),
            buttonText: __('Customize', 'jobscout'),
            buttonUrl: cw_dashboard.layout
        },
        {
            iconSvg: <Icon icon="frontpagesetting" />,
            heading: __("Front Page Settings", 'jobscout'),
            buttonText: __('Customize', 'jobscout'),
            buttonUrl: cw_dashboard.frontpage
        },
        {
            iconSvg: <Icon icon="generalsetting" />,
            heading: __("General Settings"),
            buttonText: __('Customize', 'jobscout'),
            buttonUrl: cw_dashboard.general
        },
        {
            iconSvg: <Icon icon="footersetting" />,
            heading: __('Footer Settings', 'jobscout'),
            buttonText: __('Customize', 'jobscout'),
            buttonUrl: cw_dashboard.footer
        }
    ];

    const proSettings = [
        {
            heading: __('Banner Layouts', 'jobscout'),
            para: __('Choose from different unique banner layouts.', 'jobscout'),
            buttonText: __('Learn More', 'jobscout'),
            buttonUrl: cw_dashboard?.get_pro
        },
        {
            heading: __('Multiple Layouts', 'jobscout'),
            para: __('Choose layouts for blogs, banners, posts and more.', 'jobscout'),
            buttonText: __('Learn More', 'jobscout'),
            buttonUrl: cw_dashboard?.get_pro
        },
        {
            heading: __('Multiple Sidebar', 'jobscout'),
            para: __('Set different sidebars for posts and pages.', 'jobscout'),
            buttonText: "Learn More",
            buttonUrl: cw_dashboard?.get_pro
        },
        {
            para: __('Boost your website performance with ease.', 'jobscout'),
            heading: __('Performance Settings', 'jobscout'),
            buttonText: __('Learn More', 'jobscout'),
            buttonUrl: cw_dashboard?.get_pro
        },
        {
            para: __('Choose typography for different heading tags.', 'jobscout'),
            heading: __('Typography Settings', 'jobscout'),
            buttonText: __('Learn More', 'jobscout'),
            buttonUrl: cw_dashboard?.get_pro
        },
        {
            para: __('Import the demo content to kickstart your site.', 'jobscout'),
            heading: __('One Click Demo Import', 'jobscout'),
            buttonText: __('Learn More', 'jobscout'),
            buttonUrl: cw_dashboard?.get_pro
        }
    ];

    const sidebarSettings = [
        {
            heading: __('We Value Your Feedback!', 'jobscout-pro'),
            icon: "star",
            para: __("Your review helps us improve and assists others in making informed choices. Share your thoughts today!", 'jobscout-pro'),
            imageurl: <Icon icon="review" />,
            buttonText: __('Leave a Review', 'jobscout-pro'),
            buttonUrl: cw_dashboard.review
        },
        {
            heading: __('Knowledge Base', 'jobscout-pro'),
            para: __("Need help using our theme? Visit our well-organized Knowledge Base!", 'jobscout-pro'),
            imageurl: <Icon icon="documentation" />,
            buttonText: __('Explore', 'jobscout-pro'),
            buttonUrl: cw_dashboard.docmentation
        },
        {
            heading: __('Need Assistance? ', 'jobscout-pro'),
            para: __("If you need help or have any questions, don't hesitate to contact our support team. We're here to assist you!", 'jobscout-pro'),
            imageurl: <Icon icon="supportTwo" />,
            buttonText: __('Submit a Ticket', 'jobscout-pro'),
            buttonUrl: cw_dashboard.support
        }
    ];

    return (
        <>
            <div className="customizer-settings">
                <div className="cw-customizer">
                    <Heading
                        heading="Quick Customizer Settings"
                        buttonText="Go To Customizer"
                        buttonUrl={cw_dashboard?.customizer_url}
                        openInNewTab={true}
                    />
                    <Card
                        cardList={cardLists}
                        cardPlace='customizer'
                        cardCol='three-col'
                    />
                    <Heading
                        heading="More features with Pro version"
                        buttonText="Go To Customizer"
                        buttonUrl={cw_dashboard?.customizer_url}
                        openInNewTab={true}
                    />
                    <Card
                        cardList={proSettings}
                        cardPlace='cw-pro'
                        cardCol='two-col'
                    />
                    <div className="cw-button">
                        <a href={cw_dashboard?.get_pro} target="_blank" className="cw-button-btn primary-btn long-button">{__('Learn more about the Pro version', '')}</a>
                    </div>
                </div>
                <Sidebar sidebarSettings={sidebarSettings} openInNewTab={true} />
            </div>
        </>
    );
}

export default Homepage;