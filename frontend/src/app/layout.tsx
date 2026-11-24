import type { Metadata } from 'next';
import './globals.css';
import './placex.css';

export const metadata: Metadata = {
  title: 'PlaceX — Jobs, Property, Classifieds, Vehicles, Matrimonial',
  description: 'PlaceX — Discover real opportunities, verified listings and amazing deals in your city.',
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" suppressHydrationWarning>
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link
          href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700;800;900&display=swap"
          rel="stylesheet"
        />
        <link
          rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        />
        <link rel="stylesheet" href="/placex.css" />
        <script
          dangerouslySetInnerHTML={{
            __html: `
              (function() {
                const observer = new MutationObserver(function(mutations) {
                  for (let i = 0; i < mutations.length; i++) {
                    const mutation = mutations[i];
                    if (mutation.type === 'attributes' && mutation.attributeName === 'bis_skin_checked') {
                      mutation.target.removeAttribute('bis_skin_checked');
                    }
                    if (mutation.addedNodes) {
                      mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) {
                          if (node.hasAttribute('bis_skin_checked')) {
                            node.removeAttribute('bis_skin_checked');
                          }
                          const children = node.querySelectorAll ? node.querySelectorAll('[bis_skin_checked]') : [];
                          for (let j = 0; j < children.length; j++) {
                            children[j].removeAttribute('bis_skin_checked');
                          }
                        }
                      });
                    }
                  }
                });
                observer.observe(document.documentElement, {
                  attributes: true,
                  subtree: true,
                  attributeFilter: ['bis_skin_checked']
                });
              })();
            `,
          }}
        />
      </head>
      <body suppressHydrationWarning>{children}</body>
    </html>
  );
}
