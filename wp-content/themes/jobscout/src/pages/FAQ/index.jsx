import React, { useState, useRef, useEffect } from 'react';
import { __, sprintf } from '@wordpress/i18n';
import { Icon } from '../../components';

function FAQ() {
    const faqContent = [
        {
            title: __( 'What is the difference between Free and Pro?', 'jobscout' ),
            description: (
            <>
                <p>{__( 'Both the Free and Pro version of the themes are coded well and are developed with best coding practices. However, the Pro version of the theme comes with extended features and dedicated support team to help you solve your queries. The Pro theme comes with multiple layouts to help you create a unique and attractive website. Also, the Pro themes are fully compatible with Polylang and WPML plugin to help you create a multilingual blog and get wide reach.' )}</p>
                <p>{__( 'Overall, you will have more control over the customization and editing of your website with the Pro version.', 'jobscout' )}</p>
            </>
            )
        },
        {
            title: __( 'What are the perks of upgrading to the Premium version?', 'jobscout' ),
            description: __( 'Along with the additional features and regular updates, you get dedicated and quick support with the premium theme. If you run into any issue while creating a website with the premium theme, you will get a quicker response compared to the free support.', 'jobscout' )
        },
        {
            title: __( 'Upgrading to the Pro version- will I lose my changes?', 'jobscout' ),
            description: (
            <>
                <p>{__( 'When you upgrade to the Pro theme, your posts, pages, media, categories, and other data will remain intact-- all your data is saved.', 'jobscout' )}</p>
                <p>{__( 'However, since the Pro version comes with added features and settings, you will need to set up the additional features in the customizer. This process is simple and only takes a few minutes.', 'jobscout' )}</p>
                <p>{__( 'The Pro version is built with lots of flexibility in mind for future upgrades. Therefore, it is slightly different than the free theme but extremely flexible and easy-to-use.', 'jobscout' )}</p>
            </>
            )
        },
        {
            title: __( 'How do I change the copyright text?', 'jobscout' ),
            description: (
                <p dangerouslySetInnerHTML={{ __html:sprintf(__('You can change the copyright text going to %1$s Appearance > Customize > Footer Settings. %2$s However, if you want to hide the author credit text, please %3$s.', 'jobscout'),'<b>','</b>', `<a target="_blank" href=${cw_dashboard.get_pro}>upgrade to the Pro version</a>`) }}/>
            ),
        },
        {
            title: __( 'Why is my theme not working well?', 'jobscout' ),
            description: (
            <>
                <p>{__( 'If your customizer is not loading properly or you are having issues with the theme, it might be due to the plugin conflict.', 'jobscout' )}</p>
                <p dangerouslySetInnerHTML={{ __html:sprintf(__( 'To solve the issue, deactivate all the plugins first, except the ones recommended by the theme. Then, hard reload your website using %1$s "Ctrl+Shift+R" %2$s on Windows and %1$s "Cmd+Shift+R" %2$s on Mac. If the issues are fixed, start activating the plugins one by one, and reload and check your site each time. This will help you find out the plugin that is causing the problem.', 'jobscout' ),'<b>','</b>')}} />
                <p dangerouslySetInnerHTML={{ __html:sprintf(__('If this didn\'t help, please contact us via our %s.', 'jobscout'), `<a target="_blank" href=${cw_dashboard.support}>Support Ticket.</a>`) }}/>
            </>
            )
        },
        {
            title: __( 'How can I solve my issues quickly and get faster support?', 'jobscout' ),
            description: (
            <>
                <p>{__( 'Please ensure that you have updated to the latest version of the theme before you submit a support ticket for any issue. We might have already fixed the bug in the previous theme update.', 'jobscout' )}</p>
                <p>{__( 'Also, when you submit the support ticket, please try to provide maximum details so that we can look into your issue in detail and solve it in minimum time. We recommend you to send us a screenshot(s) with issues explained and your website\'s address (URL). You can contact us ', 'jobscout' )}<a href={cw_dashboard.support} target="_blank">{__('here.', 'jobscout')}</a></p>
            </>

            )
        }
    ];

    const [openIndex, setOpenIndex] = useState(0);
    const [height, setHeight] = useState('0px');
    const contentRef = useRef(null);

    useEffect(() => {
        setHeight(openIndex !== -1 ? `${contentRef.current.scrollHeight}px` : '0px');
    }, [openIndex]);

    const toggleDescription = (index) => {
        setOpenIndex(index === openIndex ? -1 : index);
    };

    return (
        <>
            {faqContent.map((content, index) => (
                <div className="faq-item" key={index}>
                    <div className="faq-title" onClick={() => toggleDescription(index)}>
                        <h2>{content.title}</h2>
                        <span><Icon icon={openIndex === index ? 'minus' : 'plus'} /></span>
                    </div>
                    <div
                        className="faq-description"
                        ref={openIndex === index ? contentRef : null}
                        style={{
                            maxHeight: openIndex === index ? height : '0px',
                            overflow: 'hidden',
                            transition: 'max-height 0.5s ease',
                        }}
                    >
                        {typeof content.description === 'string' ? <p>{content.description}</p> : content.description}
                    </div>
                </div>
            ))}
        </>
    );
}

export default FAQ;
