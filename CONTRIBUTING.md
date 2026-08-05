# Contributing to Project AIM

Thanks for your interest in contributing to Project AIM — contributions from the community help make this project better for everyone.

This document explains how you can:
- Report bugs
- Suggest new features
- Open a pull request (PR)

1. Report a bug
- Search existing issues to avoid duplicates.
- If none found, open a new issue using the Bug Report template (.github/ISSUE_TEMPLATE/bug_report.md).
- Provide:
  - A short description
  - Steps to reproduce
  - Expected vs actual behavior
  - Environment details (PHP version, web server, Project AIM commit/tag)
  - Any relevant logs or error messages

2. Suggest a feature
- Search existing feature requests.
- If none found, open a new issue via the Feature Request template (.github/ISSUE_TEMPLATE/feature_request.md).
- Describe the problem, proposed solution, and any UX notes or screenshots.

3. Contributing code (pull requests)
- Fork the repository and create a feature branch named like: username/feature-brief-description
- Follow coding conventions used in the project (PHP/HTML/JS style).
- Make small, focused changes. One feature/fix per PR.
- Add/adjust tests where applicable.
- Update relevant documentation (README, user guide, or in-code docblocks).
- Commit messages: short summary on the first line, extra details in the body if needed.
- Open a pull request against the repository's default branch and include:
  - What the change does
  - Why it’s needed
  - Any migration or configuration steps
- If your PR changes APIs or database structure, include upgrade notes.

4. Code review and etiquette
- Be respectful and constructive.
- Respond to review comments.
- Maintain backward compatibility where possible; otherwise clearly document breaking changes.

5. Security issues
- If you discover a security vulnerability, do not open a public issue. Instead, contact the repository owner privately so the issue can be fixed before public disclosure. (Use the repository owner’s preferred contact method in the repo profile.)

6. Style & linting
- Keep HTML and JS structure consistent.
- Sanitize and escape outputs; validate/sanitize inputs.
- Avoid committing secrets (passwords, API keys, private certs).

Thank you for helping improve Project AIM!