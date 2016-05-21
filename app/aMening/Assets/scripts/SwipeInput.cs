using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Linq;
using UnityEngine.EventSystems;

public class SwipeInput : MonoBehaviour
{
    public float tweenMultipier;
    public float VelocityFalloff = 0.01f;
    private float split = 0.5f;
    public RectTransform ImageContainer;
    public Image splitImage;
    public Material splitMaterial;
    private Image[] splitImageInstance;
    private LayoutElement[] left;
    private LayoutElement[] right;
    private Text[] leftText;
    private Text[] rightText;
    private Question[] question;
    public GameObject overlay;
    protected Vector2 fingerVelocity;
    public float gravity = 1;
    public float maxVelocity;
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
    private BackgroundManager bgm;
    public float NormalTextMargin = 65;
    public float SelectedTextMargin = 30;
    public bool WaitingForMore
    {
        get
        {
            return (QueueLength != splitImageInstance.Length);
        }
    }
    public int QueueLength
    {
        get
        {
            int i;
            for (i = 0; i < splitImageInstance.Length && splitImageInstance[i] != null; i++) { }
            return i ;
        }
    }
    public bool HasQuestions
    {
        get
        {
            return question[0] != null;
        }
    }
    public float Split
    {
        get { return split; }
        set
        {
            split = Mathf.Clamp(value, 0, 1);
            if (!HasQuestions) return;
            //split
            if (!question[0].fullPicture)
            {
                splitImageInstance[0].material.SetFloat("_Split", Split);
            }
            else
            {
                splitImageInstance[0].material.SetFloat("_Split", 1);
            }
            Color tempColor;
            //base color
            float delta = 0.5f - Mathf.Abs(Split - 0.5f);
            if (delta < confirmColorSplit)
            {
                tempColor = Color.Lerp(confirmColorText, normalColorText, delta / confirmColorSplit);
                Color cBorder = Color.Lerp(confirmColorBorder, normalColorBorder, delta / confirmColorSplit);
                if (Split < 0.5f)
                {
                    rightText[0].color = tempColor;
                    rightText[0].GetComponent<Outline>().effectColor = cBorder;
                }
                else
                {
                    leftText[0].color = tempColor;
                    leftText[0].GetComponent<Outline>().effectColor = cBorder;
                }
            }
            else
            {
                leftText[0].color = rightText[0].color = normalColorText;
            }
            //alpha
            left[0].flexibleWidth = Split * 1000;
            right[0].flexibleWidth = (1 - Split) * 1000;
            tempColor = leftText[0].color;
            tempColor.a = Split * 2;
            leftText[0].color = tempColor;
            tempColor = rightText[0].color;
            tempColor.a = (1 - Split) * 2;
            rightText[0].color = tempColor;

            leftText[0].rectTransform.offsetMin = -(leftText[0].rectTransform.offsetMax = new Vector2(leftText[0].rectTransform.offsetMax.x, -Mathf.Lerp(SelectedTextMargin, NormalTextMargin, (1 - Split) * 2)));
            rightText[0].rectTransform.offsetMin = -(rightText[0].rectTransform.offsetMax = new Vector2(rightText[0].rectTransform.offsetMax.x, -Mathf.Lerp(SelectedTextMargin, NormalTextMargin, Split * 2)));

        }
    }
    public void fillQueue(bool first)
    {
        while (WaitingForMore && questionLoader.IsQuestionAvailable)
        {
            NewInstance();
        }
        UpdatePositions();
        if (!first) bgm.UpdateBG();
    }
    public void Next()
    {
        MoveQueue();
        fillQueue(false);
        Split = 0.5f;
    }
    private void UpdatePositions()
    {
        int length = QueueLength;
        for (int i = 0; i < length; i++)
        {
            splitImageInstance[i].transform.position = new Vector3(splitImageInstance[i].transform.position.x, splitImageInstance[i].transform.position.y, i - length);
        }
    }
    private void MoveQueue()
    {
        splitImageInstance[0].transform.position = new Vector3(splitImageInstance[0].transform.position.x, splitImageInstance[0].transform.position.y, splitImageInstance[0].transform.position.z - 10);
        for (int j = 0; j < splitImageInstance.Length - 1; j++)
        {
            leftText[j] = leftText[j + 1];
            rightText[j] = rightText[j + 1];
            left[j] = left[j + 1];
            right[j] = right[j + 1];
            splitImageInstance[j] = splitImageInstance[j + 1];
            question[j] = question[j + 1];
        }
        leftText[splitImageInstance.Length - 1] = null;
        rightText[splitImageInstance.Length - 1] = null;
        left[splitImageInstance.Length - 1] = null;
        right[splitImageInstance.Length - 1] = null;
        splitImageInstance[splitImageInstance.Length - 1] = null;
        question[splitImageInstance.Length - 1] = null;
    }
    private int NewInstance()
    {
        Image inst = Instantiate(splitImage);
        inst.rectTransform.SetParent(ImageContainer);
        inst.rectTransform.anchorMin = Vector2.zero;
        inst.rectTransform.anchorMax = Vector2.one;
        inst.rectTransform.localScale = Vector3.one;
        inst.rectTransform.offsetMin = inst.rectTransform.offsetMax = Vector2.zero;

        inst.rectTransform.SetAsFirstSibling();

        inst.material = new Material(splitMaterial);
        int i = QueueLength;
        if (i == splitImageInstance.Length)
        {
            return i;
        }

        leftText[i] = inst.GetComponentsInChildren<Text>().First(e => e.tag == "Left");
        rightText[i] = inst.GetComponentsInChildren<Text>().First(e => e.tag == "Right");
        left[i] = inst.GetComponentsInChildren<LayoutElement>().First(e => e.tag == "Left");
        right[i] = inst.GetComponentsInChildren<LayoutElement>().First(e => e.tag == "Right");
        splitImageInstance[i] = inst;
        inst.gameObject.SetActive(false);
        question[i] = questionLoader.NextQuestion(leftText[i], rightText[i], splitImageInstance[i].material, splitImageInstance[i].gameObject);
        return i;
    }
    void Awake()
    {
        questionLoader = GetComponent<LoadQuestion>();
        bgm = GetComponent<BackgroundManager>();

        for (int i = 0; i < ImageContainer.childCount && !selected; i++)
        {
            Destroy(ImageContainer.GetChild(i).gameObject);
        }
        int buffer = 2;
        splitImageInstance = new Image[buffer];
        leftText = new Text[buffer];
        rightText = new Text[buffer];
        left = new LayoutElement[buffer];
        right = new LayoutElement[buffer];
        question = new Question[buffer];
        fillQueue(true);
        Physics2D.gravity = new Vector2(0, -gravity * Screen.width);
    }
    void Update()
    {
        if (selected || !HasQuestions) return;

        RaycastHit hit;
        if (Input.touchCount > 0 && Physics.Raycast(Camera.main.ScreenPointToRay(Input.touches[0].position), out hit) && hit.collider.gameObject == ImageContainer.gameObject)
        {
            if (Input.touches[0].phase != TouchPhase.Moved) return;

            Split += Input.touches[0].deltaPosition.x / Screen.width / Input.touches[0].deltaTime * Time.deltaTime;
            fingerVelocity = Input.touches[0].deltaPosition / Input.touches[0].deltaTime ;

        }
        else
        {
            float delta = Split - 0.5f;
            fingerVelocity *= 1 - VelocityFalloff;
            fingerVelocity.x -= delta * tweenMultipier * Screen.width;
            Split += fingerVelocity.x * Time.deltaTime / Screen.width;

            delta = Mathf.Abs(Split - 0.5f);

            if (delta > 0.5f - confirmSplit)
            {
                Split = Mathf.Round(Split);
                StartCoroutine(Select());
            }
        }


    }
    IEnumerator Select()
    {
        selected = true;
        float timer = 0;
        Rigidbody2D rb = splitImageInstance[0].gameObject.AddComponent<Rigidbody2D>();

        rb.velocity = Vector2.ClampMagnitude(fingerVelocity / 2, maxVelocity* Screen.width); ;
        fingerVelocity = Vector2.zero;

        questionLoader.Answer(question[0], Split < 0.5f);
        Next();
        Color c;
        while (timer < 1)
        {
            timer += Time.deltaTime / timeToSelect * 2;
            foreach (Image item in overlay.GetComponentsInChildren<Image>())
            {
                c = item.color;
                c.a = timer;
                item.color = c;
            }
            yield return null;
        }
        questionLoader.SetTitle(question[0]);
        while (!HasQuestions)
        {
            yield return null;
        }
        questionLoader.SetTitle(question[0]);
        while (timer > 0)
        {
            timer -= Time.deltaTime / timeToSelect * 2;

            foreach (Image item in overlay.GetComponentsInChildren<Image>())
            {
                c = item.color;
                c.a = timer;
                item.color = c;
            }
            yield return null;
        }
        selected = false;
        yield return new WaitForSeconds(timeToDestoryQuestion);
        Destroy(rb.gameObject);
    }
}
