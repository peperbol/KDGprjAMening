using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Linq;

public class SwipeInput : MonoBehaviour
{
    public float tweenMultipier;
    float split = 0.5f;
    public RectTransform ImageContainer;
    public Image splitImage;
    public Material splitMaterial;
    private Image splitImageInstance;
    private LayoutElement left;
    private LayoutElement right;
    private Text leftText;
    private Text rightText;
    public GameObject overlay;
    public float snapSplit = 0.15f;
    public float confirmSplit = 0.005f;
    public float confirmColorSplit = 0.15f;
    public float swipeSpeedMultiplier = 2;
    bool selected = false;
    public float timeToSelect = 1;
    public Color normalColorText;
    public Color confirmColorText;
    public Color normalColorBorder;
    public Color confirmColorBorder;
    public float flyForce = 1000;
    public float flyTorque = 1000;
    public float timeToDestoryQuestion = 1;
    private LoadQuestion questionLoader;
    public float NormalTextMargin = 65;
    public float SelectedTextMargin = 30;
    public float Split
    {
        get { return split; }
        set
        {
            split = Mathf.Clamp(value, 0, 1);
            if (questionLoader.lastQuestion == null) return;
            //split
            if (!questionLoader.lastQuestion.fullPicture)
            {
                splitImageInstance.material.SetFloat("_Split", Split);
            }
            else
            {

                splitImageInstance.material.SetFloat("_Split", 1);
            }
            Color c;
            //base color
            float delta = 0.5f - Mathf.Abs(Split - 0.5f);
            if (delta < confirmColorSplit)
            {
                c = Color.Lerp(confirmColorText, normalColorText, delta / confirmColorSplit);
                Color cBorder = Color.Lerp(confirmColorBorder, normalColorBorder, delta / confirmColorSplit);
                if (Split < 0.5f)
                {
                    rightText.color = c;
                    rightText.GetComponent<Outline>().effectColor = cBorder;
                }
                else
                {
                    leftText.color = c;
                    leftText.GetComponent<Outline>().effectColor = cBorder;
                }
            }
            else
            {
                leftText.color = rightText.color = normalColorText;
            }
            //alpha
            left.flexibleWidth = Split * 1000;
            right.flexibleWidth = (1 - Split) * 1000;
            c = leftText.color;
            c.a = Split * 2;
            leftText.color = c;
            c = rightText.color;
            c.a = (1 - Split) * 2;
            rightText.color = c;

            leftText.rectTransform.offsetMin = -(leftText.rectTransform.offsetMax = new Vector2(leftText.rectTransform.offsetMax.x, -Mathf.Lerp(SelectedTextMargin, NormalTextMargin, (1 - Split) * 2)));
            rightText.rectTransform.offsetMin = -(rightText.rectTransform.offsetMax = new Vector2(rightText.rectTransform.offsetMax.x, -Mathf.Lerp(SelectedTextMargin, NormalTextMargin, Split * 2)));

        }
    }

    public Image NewInstance()
    {
        Image inst = Instantiate(splitImage);
        inst.rectTransform.SetParent(ImageContainer);
        inst.rectTransform.anchorMin = Vector2.zero;
        inst.rectTransform.anchorMax = Vector2.one;
        inst.rectTransform.localScale = Vector3.one;
        inst.rectTransform.offsetMin = inst.rectTransform.offsetMax = Vector2.zero;

        inst.rectTransform.SetAsFirstSibling();

        inst.material = new Material(splitMaterial);
        leftText = inst.GetComponentsInChildren<Text>().First(e => e.tag == "Left");
        rightText = inst.GetComponentsInChildren<Text>().First(e => e.tag == "Right");
        left = inst.GetComponentsInChildren<LayoutElement>().First(e => e.tag == "Left");
        right = inst.GetComponentsInChildren<LayoutElement>().First(e => e.tag == "Right");
        splitImageInstance = inst;
        return inst;
    }
    void OnEnable()
    {
        questionLoader = FindObjectOfType<LoadQuestion>();
        
        for (int i = 0; i < ImageContainer.childCount && !selected; i++)
        {
            Destroy(ImageContainer.GetChild(i).gameObject);
        }

        NewInstance();
        if (!questionLoader.NextQuestion(leftText, rightText, splitImageInstance.material))
        {
            Destroy(splitImageInstance.gameObject);
        }
        questionLoader.SetTitle();
        Split = 0.5f;

    }
    void Update()
    {
        if (selected) return;
        if (Input.touchCount > 0)
        {
            Split += Input.touches[0].deltaPosition.x / ImageContainer.rect.size.x * swipeSpeedMultiplier;
        }
        else
        {
            float delta = Mathf.Abs(Split - 0.5f);
            if (delta < 0.5f - snapSplit)
            {
                delta *= tweenMultipier;
                if (Split > 0.5f)
                {
                    Split -= delta;
                }
                else
                {
                    Split += delta;
                }
            }
            else if (delta < 0.5f - confirmSplit)
            {

                delta *= 0.5f - tweenMultipier;
                if (Split > 0.5f)
                {
                    Split += delta;
                }
                else
                {
                    Split -= delta;
                }
            }
            else
            {
                Split = Mathf.Round(Split);
                StartCoroutine(Select());
            }
        }


    }
    IEnumerator Select()
    {
        selected = true;
        float time = 0;

        Rigidbody2D rb = splitImageInstance.gameObject.AddComponent<Rigidbody2D>();

        if (Split > 0.5f)
        {
            rb.AddForce(Vector2.right * flyForce / ImageContainer.rect.size.x);
            rb.AddTorque(flyTorque);
        }
        else
        {
            rb.AddForce(Vector2.left * flyForce / ImageContainer.rect.size.x);
            rb.AddTorque(-flyTorque);
        }

        NewInstance();

        if (!questionLoader.NextQuestion(leftText, rightText, splitImageInstance.material))
        {
            Destroy(splitImageInstance.gameObject);
        }
        Split = 0.5f;
        Color c;
        while (time < 1)
        {
            time += Time.deltaTime / timeToSelect * 2;
            foreach (Image item in overlay.GetComponentsInChildren<Image>())
            {
                c = item.color;
                c.a = time;
                item.color = c;
            }
            yield return null;
        }
        questionLoader.SetTitle();

        while (time > 0)
        {
            time -= Time.deltaTime / timeToSelect * 2;

            foreach (Image item in overlay.GetComponentsInChildren<Image>())
            {
                c = item.color;
                c.a = time;
                item.color = c;
            }
            yield return null;
        }
        selected = false;
        yield return new WaitForSeconds(timeToDestoryQuestion);
        Destroy(rb.gameObject);
    }
}
